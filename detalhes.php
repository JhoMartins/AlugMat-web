<?php
	$titulo = "Loja de Miniatura";
	require_once('includes/cabecalho_site.php');
	
	if ((isset($_GET['produto'])) && (is_numeric($_GET['produto']))) {
		$produto = $_GET['produto'];
	}
	else if ((isset($_POST['produto'])) && (is_numeric($_POST['produto']))) {
		$produto = $_POST['produto'];
	}
	else {
		exit;
	}

	require_once('includes/conexao.php');

	
	
	if (isset($_POST['enviou'])) {
		$erros = array();
		
		//COMENTÁRIO
		if (trim($_POST['comentario']) != "") {
			
			$comentario = mysqli_real_escape_string($dbc,$_POST['comentario']);
		}
		else {
			$erros[] = "Por favor, digite um comentário sobre o produto.";
		}
		
		//NOTA
		if (!isset($_POST['nota'])) {
			$erros[] = "Por favor, informe uma quantidade de estrelas para o produto.";
		}
		else {
			$nota = $_POST['nota'];
		}
		
		if (empty($erros)) {
			
			$qry = "insert into comentarios (
										cd_cliente,
										cd_produto,
										nota,
										comentario
								) values (
										".$_SESSION['id'].",
										$produto,
										$nota,
										'$comentario')";
										//die($qry);
			$res = @mysqli_query($dbc,$qry);
			
			$soma_notas = "select sum(nota) total_nota from comentarios where cd_produto = $produto";
			$res_soma_notas = mysqli_query($dbc,$soma_notas);
			$total_nota = mysqli_fetch_array($res_soma_notas);
			
			$conta_avaliacoes = "select count(*) total_avaliacoes from comentarios where cd_produto = $produto";
			$res_conta_avaliacoes = mysqli_query($dbc,$conta_avaliacoes);
			$total_avaliacoes = mysqli_fetch_array($res_conta_avaliacoes);
			
			$nota_media = $total_nota['total_nota'] / $total_avaliacoes['total_avaliacoes'];
			
			$upd = "update produto set nota = $nota_media where id = $produto";
			$res_upd = mysqli_query($dbc,$upd);
			
			if ($res) {
				$sucesso = "<h1><strong>Sucesso!</strong></h1>
							<p>Seu comentário foi enviado com sucesso!</p>";
				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=detalhes.php?produto=$produto'>";
			}
			else {
				$erro = "<h1><strong>Erro no Sistema</strong></h1>
						 <p>Você não pode ser registrado devido a um erro do sistema. Pedimos desculpas por qualquer inconveniente.</p>";
				
				$erro .= '<p>' . mysqli_error($dbc) . '<br /> Query: ' . $q . '</p>';
			}
		}
		
		//Se existem erros, exibir para o usuário
		else {
			
			$erro = "<h1><strong>Erro!</strong></h1>
					 <p>Ocorreram o(s) seguinte(s) erro(s):<br />";
					 
			foreach ($erros as $msg) {
				
				$erro .= " - $msg <br /> \n";
			}
			
			$erro .= "</p><p>Por favor, tente novamente.</p>";
		}
	}
	
	
	$sql = "select * from produto where id = $produto";
	$rs = mysqli_query($dbc, $sql);
	//die(var_dump($rs));
	if (mysqli_num_rows($rs) == 1) {
	
		$reg = mysqli_fetch_array($rs);
	
		$id = $reg["ID"];
		$descricao = $reg["DESCRICAO"];
		$cd_interno = $reg["CD_INTERNO"];
		$valor_diaria = $reg["VALOR_DIARIA"];
		$status = $reg["STATUS"];
		$disponivel = $reg["DISPONIVEL"];
		$caracteristicas = $reg["CARACTERISTICAS"];
		$categoria = $reg["CATEGORIA"];
		$marca = $reg["MARCA"];
		$fornecedor = $reg["FORNECEDOR"];
		$nota = (isset($reg["NOTA"])) ? $reg["NOTA"] : 0;
		
		if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; 
		
		if (isset($sucesso)) echo "<div class='alert alert-success'>$sucesso</div>";
?>

<script src="funcoes.js"></script>
<script type="text/JavaScript">
//Função de abertura da janela de imagens ampliadas
function ampliar_imagem(url,nome_janela,parametros)
{
	window.open(url,nome_janela,parametros);
}
</script>

<!-- Menu Categorias -->
<div class="row">
	<?php include_once('includes/menu_categorias.php'); ?>
</div>

<!-- Título da página (exibe o nome da categoria -->
<h4>Detalhes <img src="img/marcador_setaDir.gif" 
	align="adsmiddle" /> <?= $categoria; ?>
	<img src="img/marcador_setaDir.gif" 
	align="adsmiddle" /> <?php echo $descricao; ?> </h4>
	
<div class="row">
  <div class="col-md-2">
  <!-- Exibe imagem da miniatura com opção de ampliação -->
  <a href="#"><img src="img/<?php echo $codigo; ?>G.jpg"
	width="200" height="121" border="0" 
	onclick="ampliar_imagem('ampliar.php?codigo=<?= $codigo; ?>&nome=<?= $nome; ?>','','width=522,height=338,top=50,left=50')" 
	class="img-responsive" /></a>
	<br />
  <a href="#"><img src="img/btn_ampliar.gif"
	width="200" height="121" border="0" 
	onclick="ampliar_imagem('ampliar.php?codigo=<?= $codigo; ?>&nome=<?= $nome; ?>','','width=522,height=338,top=50,left=50')"
	class="img-responsive" /></a>
 <h4>Dados técnicos</h4>
	Código: <strong><?= $cd_interno; ?></strong><br />
	Descrição: <strong><?= $descricao; ?></strong><br />
	Marca: <strong><?= $marca; ?></strong><br />
	Categoria: <strong><?= $categoria; ?></strong><br />
	Fornecedor: <strong><?= $fornecedor; ?></strong><br />
	Avaliação: <strong><?php if ($nota == 0) { echo "Não há avaliações para este produto."; } else if ($nota <= 1) { echo $nota . " estrela"; } else { echo $nota . " estrelas"; }?></strong><br />
	
	
	
  </div>
  <div class="col-md-10 jumbotron">
    <div class="row">
	  <div class="col-md-10">
	    <h3><strong><?= $descricao; ?></strong></h3>
		<h4>Valor da Diária: R$ <strong><?= number_format($valor_diaria,2,',','.'); ?></strong></h4>
		Características: <strong><?= $caracteristicas; ?></strong><br /><br /> 
			  <?php if ($status == "S") { ?>
	    <a href="cesta.php?produto=<?= $codigo; ?>&inserir=S"
		  class="btn btn-success" alt="Comprar" />Reservar</a>
	  <?php } else { ?>
	    <img src="img/btn_comprar_nd.gif" 
		alt="Não disponível no estoque" hspace="5"
		border="0" align="right" />

	  <?php } ?>
	</div>
</div>
</div>
<div class="row">
	<form class="form-group col-md-8" method="post" action="">
		<div>
			<h4>Deixe Seu Comentário</h4>
			<textarea class="form-control counted" name="comentario" <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo 'placeholder="Faça login para deixar seu comentário."'; } else { echo 'placeholder="Digite seu Comentário"'; } ?> rows="5" style="margin-bottom:10px;" <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?>><?php if (isset($comentario)) { echo $comentario; } ?></textarea>
		</div>
		
		<div class="wrapper">
			<input type="radio" id="st1" name="nota" value="5" <?php if (isset($_POST['nota']) && $_POST['nota'] == 5) { echo 'checked'; }?> <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?> />
			<label for="st1"></label>
			<input type="radio" id="st2" name="nota" value="4" <?php if (isset($_POST['nota']) && $_POST['nota'] == 4) { echo 'checked'; }?> <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?> />
			<label for="st2"></label>
			<input type="radio" id="st3" name="nota" value="3" <?php if (isset($_POST['nota']) && $_POST['nota'] == 3) { echo 'checked'; }?> <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?> />
			<label for="st3"></label>
			<input type="radio" id="st4" name="nota" value="2" <?php if (isset($_POST['nota']) && $_POST['nota'] == 2) { echo 'checked'; }?> <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?> />
			<label for="st4"></label>
			<input type="radio" id="st5" name="nota" value="1" <?php if (isset($_POST['nota']) && $_POST['nota'] == 1) { echo 'checked'; }?> <?php if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] == 'ADM') { echo "disabled"; } ?> />
			<label for="st5"></label>
		</div>
		
		<br />
		<button type="submit" class="btn btn-primary">Enviar Comentário</button>
		<input type="hidden" name="enviou" value="True" />
		<input type="hidden" name="produto" value="<?= $id; ?>" />
	</form>	
</div>
<?php
	}
	
	$sqlc = "select co.*, c.nome
	 		 from comentarios co
	 		 inner join cliente c on c.id = co.cd_cliente
	 		 where co.cd_produto = $produto
			 order by id desc";
			 //die("<pre>".$sqlc."</pre>");
	$resc = mysqli_query($dbc, $sqlc);
	
	if (mysqli_num_rows($resc) > 0) {
		echo '<br /><div class="row">
				<div class="col-md-2">
				</div>
				<div class="table-responsive col-md-10">
					<h4><strong>Avaliações do Produto</strong></h4><br />
						<table class="table table-striped">';
	}
	
	$i = 1;
	
	while ($regc = mysqli_fetch_array($resc)) {
		$usuario = $regc['nome'];
		$comentario = $regc['COMENTARIO'];
		$estrelas = $regc['NOTA'];
		
		//die("usuário: ".$usuario." - Comentário: ".$comentario." - Estrelas: ".$estrelas);
		
		if ($estrelas == 1) {
			$notac = '<div class="wrapper">
							<input type="radio" id="st1" name="nota'.$i.'" value="5" />
							<label for="st1"></label>
							<input type="radio" id="st2" name="nota'.$i.'" value="4" />
							<label for="st2"></label>
							<input type="radio" id="st3" name="nota'.$i.'" value="3" />
							<label for="st3"></label>
							<input type="radio" id="st4" name="nota'.$i.'" value="2" />
							<label for="st4"></label>
							<input type="radio" id="st5" name="nota'.$i.'" value="1" checked />
							<label for="st5"></label>
						</div>';
		}
		else if ($estrelas == 2) {
			$notac = '<div class="wrapper">
							<input type="radio" id="st1" name="nota'.$i.'" value="5" />
							<label for="st1"></label>
							<input type="radio" id="st2" name="nota'.$i.'" value="4" />
							<label for="st2"></label>
							<input type="radio" id="st3" name="nota'.$i.'" value="3" />
							<label for="st3"></label>
							<input type="radio" id="st4" name="nota'.$i.'" value="2" checked />
							<label for="st4"></label>
							<input type="radio" id="st5" name="nota'.$i.'" value="1" />
							<label for="st5"></label>
						</div>';
		}
		else if ($estrelas == 3) {
			$notac = '<div class="wrapper">
							<input type="radio" id="st1" name="nota'.$i.'" value="5" />
							<label for="st1"></label>
							<input type="radio" id="st2" name="nota'.$i.'" value="4" />
							<label for="st2"></label>
							<input type="radio" id="st3" name="nota'.$i.'" value="3" checked />
							<label for="st3"></label>
							<input type="radio" id="st4" name="nota'.$i.'" value="2" />
							<label for="st4"></label>
							<input type="radio" id="st5" name="nota'.$i.'" value="1" />
							<label for="st5"></label>
						</div>';
		}
		else if ($estrelas == 4) {
			$notac = '<div class="wrapper">
							<input type="radio" id="st1" name="nota'.$i.'" value="5" />
							<label for="st1"></label>
							<input type="radio" id="st2" name="nota'.$i.'" value="4" checked />
							<label for="st2"></label>
							<input type="radio" id="st3" name="nota'.$i.'" value="3" />
							<label for="st3"></label>
							<input type="radio" id="st4" name="nota'.$i.'" value="2" />
							<label for="st4"></label>
							<input type="radio" id="st5" name="nota'.$i.'" value="1" />
							<label for="st5"></label>
						</div>';
		}
		else if ($estrelas == 5) {
			$notac = '<div class="wrapper">
							<input type="radio" id="st1" name="nota'.$i.'" value="5" checked />
							<label for="st1"></label>
							<input type="radio" id="st2" name="nota'.$i.'" value="4" />
							<label for="st2"></label>
							<input type="radio" id="st3" name="nota'.$i.'" value="3" />
							<label for="st3"></label>
							<input type="radio" id="st4" name="nota'.$i.'" value="2" />
							<label for="st4"></label>
							<input type="radio" id="st5" name="nota'.$i.'" value="1" />
							<label for="st5"></label>
						</div>';
		}
	
		echo '<tr>
				<td width="10%"><strong>'.$usuario.'</strong></td>
				<td width="40%">'.$comentario.'</td>
				<td width="10%">'.$notac.'</td>
			  </tr>';	
			  
		$i++;
	}
	
	if (mysqli_num_rows($resc) > 0) {
		echo '</table></div></div>';
	}
?>

<!-- Fechar DIV ROW -->
</div>


<?php	
	include_once("includes/rodape.php");

	mysqli_free_result($rs);
	mysqli_close($dbc);
?>