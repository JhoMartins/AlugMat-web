<?php
	$titulo = "Loja de Miniaturas - Categorias";
	require_once('includes/cabecalho_site.php');
	require_once('includes/conexao.php');

	//Recuperar as categorias
	$categoria = $_GET['categoria'];

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

	//Seleciona as miniaturas pelo id de categoria
	$qry = "select * from produto
		  where categoria = '" . $categoria . "'
		    and status = 'S' 
		  order by " . $ordenar;
	//die("<pre>".$qry."</pre>");
	
	$res = @mysqli_query($dbc,$qry);
	$total_registros = mysqli_num_rows($res);
?>

	<!--Menu Categorias --> 
<div class="row">
	<?php
		include_once('includes/menu_categorias.php');
	?>
</div>

<!--Decoração Home Page -->
<div class="row">
	<div class="col-md-12">
		<img src="img/<?= $categoria; ?>.jpg" width="1200px" class="img-responsive" />
	</div>
</div> 

<!--Título da página e Ordenação de registros -->
<div class="row">
	<div class="col-md-8">
		<h4>Destaques [Total de itens em destaque: <?php echo $total_registros; ?>]</h4>
	</div>
	<div class="col-md-4">
		<span class="h4 pull-right"> 
			Ordenar por:
		<?php if ($ordenar == "valor_diaria asc") { ?>
			<span class="label label-primary">Menor Preço</span>
			<a href="<?php dirname($_SERVER['PHP_SELF']); ?>?categoria=<?= $categoria; ?>&ordenar=valor_diaria desc">Maior Preço</a>
		<?php } else { ?>
			<a href="<?php dirname($_SERVER['PHP_SELF']); ?>?categoria=<?= $categoria; ?>&ordenar=valor_diaria asc">Menor Preço</a>
			<span class="label label-primary">Maior Preço</span>
		<?php } ?>
		</span>
	</div>
</div>

<!-- Exibição dos Itens -->
<?php
	for ($contador = 0; $contador < $total_registros; $contador++)
	{
		$reg = @mysqli_fetch_array($res, MYSQLI_ASSOC);
		
		$id = $reg["ID"];
		$descricao = $reg["DESCRICAO"];
		$cd_interno = $reg["CD_INTERNO"];
		$valor_diaria = $reg["VALOR_DIARIA"];
		$status = $reg["STATUS"];
		$disponivel = $reg["DISPONIVEL"];
		$caracteristicas = $reg["CARACTERISTICAS"];
		$marca = $reg["MARCA"];
		$fornecedor = $reg["FORNECEDOR"];
		$nota = $reg["NOTA"];

		//Exibe dados da coluna esquerda
		if ($contador % 2 == 0){
		
?>
<!--Cria uma nova linha -->
<div class="row">
		<!--Monta a coluna da esquerda -->
		<div class="col-md-6">
			<div class="col-md-4">
				<a href="#"><img src="imagens/<?php echo $id; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="imagens/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $descricao; ?></strong><br />
			Valor da Diária: <strong>R$ <?php echo number_format($valor_diaria,2,',','.'); ?></strong>
			<h6>Código: <?php echo $cd_interno; ?> </h6>
			<a href="detalhes.php?produto=<?= $id; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($disponivel = 'S') {?>
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
				<a href="#"><img src="imagens/<?= $id; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="imagens/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $descricao; ?></strong><br />
			Valor da Diária: <strong>R$ <?php echo number_format($valor_diaria,2,',','.'); ?></strong>
			<h6>Código: <?php echo $cd_interno; ?> </h6>
			<a href="detalhes.php?produto=<?= $id; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($disponivel = 'S') {?>
			<img src="imagens/btn_detalhes_nd.gif" vspace="5" border="0"> <?php } ?> <br /><br />
		</div>
		</div>
	<!--Finaliza a Linha -->
	</div>
	<?php
		} //Encerra o else
	} //Encerra o for
	mysqli_free_result($res);
	mysqli_close($dbc);
	?>