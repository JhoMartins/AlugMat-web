<?php
	$titulo = "Loja de Miniaturas - Categorias";
	require_once('includes/cabecalho_site.php');
	require_once('includes/conexao.php');

	//Número de registros exibidos na tela
	$exiba = 10;
	
	//Recuperar as categorias
	$categoria = $_GET['categoria'];
	
	$q = "select count(id) from produto where categoria = '$categoria' and status = 'S'";
	//die($q);
	$r = @mysqli_query($dbc,$q);
	$row = @mysqli_fetch_array($r, MYSQLI_NUM);
	$qtde = $row[0];

	//Seleciona as miniaturas pelo id de categoria
	if (isset($_GET['p']) && is_numeric($_GET['p'])) {
		$pagina = $_GET['p'];
	}
	else {
		if ($qtde > $exiba) {
			$pagina = ceil($qtde/$exiba);
		}
		else {
			$pagina = 1;
		}
	}
	
	if (isset($_GET['s']) && is_numeric($_GET['s'])) {
		$inicio = $_GET['s'];
	}
	else {
		$inicio = 0;
	}

	
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
	
	
	$qry = "select * from produto
		  where categoria = '" . $categoria . "'
			and status = 'S' 
		  order by " . $ordenar . "
		  limit $inicio, $exiba";
	//die("<pre>".$qry."</pre>");
	
	$res = @mysqli_query($dbc,$qry);
	
	
	if ($pagina > 1) {
		$pag = '';
		$pagina_correta = ($inicio/$exiba) + 1;
		
		//Botão ANTERIOR
		if ($pagina_correta != 1) {
			$pag .= '<li class="prior"><a href="categorias.php?categoria=' . $categoria . '&s=' . ($inicio - $exiba) . '&p=' . $pagina . '&ordem=' . $ordenar . '">Anterior</a><li>';
		}
		else {
			$pag .= '<li class="disabled"><a>Anterior</a></li>';
		}
		
		//Numerações das PÁGINAS
		for ($i = 1; $i <= $pagina; $i++) {
			if ($i != $pagina_correta) {
				$pag .= '<li><a href="categorias.php?categoria=' . $categoria . '&s=' . ($exiba * ($i - 1)) . '&p=' . $pagina . '&ordem=' . $ordenar . '">' . $i . '</a></li>';
			}
			else {
				$pag .= '<li class="disabled"><a>' . $i . '</a></li>';
			}
		}
		
		//Botão PRÓXIMO
		if ($pagina_correta != $pagina) {
			$pag .= '<li class="next"><a href="categorias.php?categoria=' . $categoria . '&s=' . ($inicio + $exiba) . '&p=' . $pagina . '&ordem=' . $ordenar . '">Próximo</a></li>';
		}
		else {
			$pag .= '<li class="disabled"><a>Próximo</a></li>';
		}
	}
	
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
		<h4>Total de <?php if ($categoria == 'pecas') echo 'Peças: '; else if ($categoria == 'ferramentas') echo 'Ferramentas: '; else echo 'Máquinas: '; echo $qtde; ?></h4>
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
	$contador = 0;
	
	while ($reg = mysqli_fetch_array($res,MYSQLI_ASSOC)) {		
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
				<a href="#"><img src="img/<?= $id; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="img/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $descricao; ?></strong><br />
			Valor da Diária: <strong>R$ <?php echo number_format($valor_diaria,2,',','.'); ?></strong>
			<h6>Código: <?php echo $cd_interno; ?> </h6>
			<a href="detalhes.php?produto=<?= $id; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($disponivel == 'N') {?>
			<img src="img/btn_detalhes_nd.gif" vspace="5" border="0"> <?php } ?> <br /><br />
		</div>
		</div>
		<?php
		//Exibe dados da coluna da direita
			$contador++;
		}
		else
		{
			?>
			<!--Monta a coluna da Direita -->
		<div class="col-md-6">
			<div class="col-md-4">
				<a href="#"><img src="img/<?= $id; ?>.jpg"
					width="140" height="85" border="0" />
				</a> <br />
				<img src="img/btn_ampliar1.gif"
					width="140" height="16" border="0" />
			</div>
		<div class="col-md-8">
			<strong><?php echo $descricao; ?></strong><br />
			Valor da Diária: <strong>R$ <?php echo number_format($valor_diaria,2,',','.'); ?></strong>
			<h6>Código: <?php echo $cd_interno; ?> </h6>
			<a href="detalhes.php?produto=<?= $id; ?>" class="btn btn-xs btn-success">Mais Detalhes</a>
			<?php if($disponivel == 'N') {?>
			<img src="img/btn_detalhes_nd.gif" vspace="5" border="0"> <?php } ?> <br /><br />
		</div>
		</div>
	<!--Finaliza a Linha -->
	</div>
	<?php
			$contador++;
		} //Encerra o else
	} //Encerra o for
	?>
	
	<div id="botton" class="row col-md-12">
	  <ul class="pagination">
		<?php if (isset($pag)) {echo $pag;} ?>
	  </ul>
	</div>

<?php
	include_once('includes/rodape.php');
	mysqli_free_result($res);
	mysqli_close($dbc);
?>