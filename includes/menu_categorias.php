<?php
	$categ = isset($_GET['cat_nome']) ? $_GET['cat_nome'] : 'Home';



?>

<ul class="nav nav-tabs" role="tablist">
	<li <?php if ($categ == 'Home' ) echo ' class="active" ';?>><a href="index-.php">Home</a></li>
	<li <?php if ($categ == 'Pecas' ) echo ' class= "active" ';?>><a href="categorias.php?cat_id=6&cat_nome=Aviões&ordenar=preco ASC">Peças</a></li>
	<li <?php if ($categ == 'Maquinas' ) echo ' class="active" ';?>><a href="categorias.php?cat_id=4&cat_nome=Caminhões&ordenar=preco ASC">Maquinas</a></li>
	
	<li <?php if ($categ == 'Ferramentas' ) echo ' class="active" ';?>><a href="categorias.php?cat_id=7&cat_nome=Militares&ordenar=preco ASC">Ferramentas</a></li>
	
</ul>