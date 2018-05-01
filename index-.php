<?php
	$titulo = "Loja de Miniaturas";
	require_once('includes/cabecalho_site.php');
	require_once('includes/conexao.php');

	//Ordenação das ofertas por ordem de preço
	$ordenar = isset($_GET['ordenar']);
		if ($ordenar == "")
		{
			$ordenar = "valor_diaria desc";
		}
		else
		{
			$ordenar = $_GET['ordenar'];
		}

	//Selecionar as ofertas em destaque
	$q = "select * from produto
		  where destaque = 'S' 
		  ORDER BY " . $ordenar;

	$r = @mysqli_query($dbc,$q);
	$total_registros = mysqli_num_rows($r);
?>

	<!--Menu Categorias --> 
<div class="row">
	<?php
		include_once('includes/menu_categorias.php');
	?>
</div>

<!--Decoração Home Page -->
<div class="row">
	<div class="col-md-13">
		<img src="img/teste.png" width="1200x" class="img-responsive" />
	</div>
</div> 

<!--Título da página e Ordenação de registros -->
<div class="row">
	<div class="col-md-8">
		<h4> Destaques [Total de itens em destaque:
			<?php echo $total_registros; ?>]
		</h4>
	</div>
	<div class="col-md-4">
		<span class="h4 pull-right"> 
			Ordenar por:
		<?php if ($ordenar == "preco ASC") { ?>
		<span class="label label-primary"> Menor Preço:</span>
		<a href="index.php?ordenar=preco DESC">
		Maior Preço: </a>
		<?php } else { ?>
			<a href="index.php?ordenar=preco ASC">
			Menor Preço: </a>
			<span class="label label-primary"> Maior Preço:</span>
			<?php } ?>
		</span>
	</div>
</div>

<!-- Exibição dos Itens -->
<?php
	for ($contador = 0; $contador < $total_registros; $contador++)
	{
		$reg = @mysqli_fetch_array($r, MYSQLI_ASSOC);
		$codigo = $reg["codigo"];
		$nome = $reg["nome"];
		$estoque = $reg["estoque"];
		$min_estoque = $reg["min_estoque"];
		$preco = $reg["preco"];
		$desconto = $reg["desconto"];
		$credito = $reg["credito"];
		$valor_desconto = $preco - ($preco * $desconto / 100);

		//Exibe dados da coluna esquerda
		if ($contador % 2 == 0){
		
?>
<!--Cria uma nova linha -->
<div class="row">
		<!--Monta a coluna da esquerda -->
		<div class="col-md-6">
			<div class="col-md-4">
				<a href="#"><img src="imagens/<?php echo $codigo; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="imagens/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $nome; ?></strong>
			<s>de R$ <?php echo number_format($preco,2,',','.'); ?> </s><br />
			Por: <strong>R$ <?php echo number_format($valor_desconto,2,',','.'); ?></strong> no cartão
			<h6>Crédito da imagem: <?php echo $credito; ?> </h6>
			<a href="detalhes.php?produto=<?php echo $codigo; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($estoque< $min_estoque) {?>
			<img src="imagens/btn_detalhes_nd.gif" vspace="5" border="0"> <?php } ?> <br /><br />
		</div>
		</div>
		<?php
		//Exibe dados da coluna da direita
		}
		else
		{
			?>
			<!--Monta a coluna da Direita -->
		<div class="col-md-6">
			<div class="col-md-4">
				<a href="#"><img src="imagens/<?php echo $codigo; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="imagens/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $nome; ?></strong>
			<s>de R$ <?php echo number_format($preco,2,',','.'); ?> </s><br />
			Por: <strong>R$ <?php echo number_format($valor_desconto,2,',','.'); ?></strong> no cartão
			<h6>Crédito da imagem: <?php echo $credito; ?> </h6>
			<a href="detalhes.php?produto=<?php echo $codigo; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($estoque< $min_estoque) {?>
			<img src="imagens/btn_detalhes_nd.gif" vspace="5" border="0"> <?php } ?> <br /><br />
		</div>
		</div>
	<!--Finaliza a Linha -->
	<?php
		} //Encerra o else
	} //Encerra o for
	mysqli_free_result($r);
	mysqli_close($dbc);
	?>
		<?php
		include_once('includes/rodape.php');
		?>
