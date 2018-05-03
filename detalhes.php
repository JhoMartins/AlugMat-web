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
	Categoria: <strong><?= $categoria; ?></strong><br />
	
	
  </div>
  <div class="col-md-10 jumbotron">
    <div class="row">
	  <div class="col-md-10">
	    <h3><strong><?= $descricao; ?></strong></h3>
		<h4>Valor: R$ <strong><?= number_format($valor_diaria,2,',','.'); ?></strong></h4><br />
	  </div>
	  <div class="col-md-2 pull-right">
	  <!-- se a quantidade em estoque for maior que o estoque minimo -->
	  <?php if ($status == "S") { ?>
	    <a href="cesta.php?produto=<?= $codigo; ?>&inserir=S"
		  class="btn btn-success" alt="Comprar" />Solicitar</a>
	  <?php } else { ?>
	    <img src="img/btn_comprar_nd.gif" 
		alt="Não disponível no estoque" hspace="5"
		border="0" align="right" />
	  <?php } ?>
	  </div>
	</div>
	
	
	
	<div class="row">
		<div class="col-md-12">
		* Pague com Cartão de Crédito ou no Boleto Bancário 
		<strong>
		<?= number_format($valor_diaria,2,',','.'); ?>
		</strong><br />
		
		
		<strong>Formas de Pagamento</strong>
		<img src="img/banner_formapag.gif"
			alt="Forma de Pagamento"
			width="297"
			height="23"
			vspace="5" /><br />
		
		<strong>Prazos de Entrega</strong><br />
		2 dias úteis para o estado de São Paulo. <br />
		5 dias úteis para os demais estados. <br /><br />
		
		<strong>Observações</strong><br />
		As mercadorias adquiridas serão despachadas, 
		via Sedex (sedex ou e-Sedex), no primeiro dia
		útil após a comprovação do pagamento,
		estando a entrega condicionada à disponibilidade 
		de estoque.
		Prazo médio de entrega dos Correios: 24 à 72 horas.
		</div>
	</div>
  </div>
</div>

<?php
  mysqli_free_result($rs);
  mysqli_close($dbc);
?>