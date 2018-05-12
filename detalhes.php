<?php
  $titulo = "Loja de Miniatura";
  require_once('includes/cabecalho_site.php');
  require_once('includes/conexao.php');
  
  $produto = $_GET['produto'];
  
  $sql = "select * from produto 
  where id = '" . $produto . "'";
			
  $rs = mysqli_query($dbc, $sql);
  $reg = mysqli_fetch_array($rs);
  
		$descricao = $reg["DESCRICAO"];
		$cd_interno = $reg["CD_INTERNO"];
		$valor_diaria = $reg["VALOR_DIARIA"];
		$status = $reg["STATUS"];
		$disponivel = $reg["DISPONIVEL"];
		$caracteristicas = $reg["CARACTERISTICAS"];
		$categoria = $reg["CATEGORIA"];
		$marca = $reg["MARCA"];
		$fornecedor = $reg["FORNECEDOR"];
		$nota = $reg["NOTA"];
?>

<?php
if (isset($_POST['enviou'])) {
		require_once('../includes/conexao.php');
		
		$erros = array();
//Comentário
		if (trim($_POST['Comentarios']) != "") {
			$Comentarios = mysqli_real_escape_string($dbc,$_POST['Comentarios']);
		}
		else {
			$caracteristicas = NULL;
		}

		if (empty($erros)) {
			$qry = "insert into Comentarios (
										Comentario
								) values (
										'$Comentarios',
										NOW())";
			$res = @mysqli_query($dbc,$qry);
			
			if ($res) {
				$sucesso = "<h1><strong>Sucesso!</strong></h1>
							<p>Seu registro foi incluido com sucesso!</p>
							<p>Aguarde... Redirecionando!</p>";
				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=menu_principal.php'>";
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
		
		mysqli_close($dbc);
	}
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
	Características: <strong><?= $caracteristicas; ?></strong><br />
	Marca: <strong><?= $marca; ?></strong><br />
	Categoria: <strong><?= $categoria; ?></strong><br />
	Fornecedor: <strong><?= $fornecedor; ?></strong><br />
	
	
	
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
	<form class="form-group col-md-8">
				<div>
					<h4>Deixe Seu Comentário</h4>
					<textarea class="form-control counted" name="message" placeholder="Digite seu Comentario" rows="5" style="margin-bottom:10px;"></textarea>
				</div>	
				<div class="wrapper" >
 					<input type="checkbox" id="st1" value="1" />
 					<label for="st1"></label>
 					<input type="checkbox" id="st2" value="2" />
 					<label for="st2"></label>
 					<input type="checkbox" id="st3" value="3" />
 					<label for="st3"></label>
 					<input type="checkbox" id="st4" value="4" />
 					<label for="st4"></label>
 					<input type="checkbox" id="st5" value="5" />
 					<label for="st5"></label>
				</div>
				<br />
				<button type="submit" class="btn btn-primary">Enviar Comentário</button>
			</form>	
			

 

<?php
  mysqli_free_result($rs);
  mysqli_close($dbc);
?>