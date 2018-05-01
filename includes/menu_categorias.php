<?php
	$categ = isset($_GET['categoria']) ? $_GET['categoria'] : 'Home';
?>

<ul class="nav nav-tabs" role="tablist">
	<li <?php if ($categ == 'Home' ) echo ' class="active" ';?>><a href="index-.php">Home</a></li>
	<li <?php if ($categ == 'pecas' ) echo ' class= "active" ';?>><a href="categorias.php?categoria=pecas&ordenar=valor_diaria asc">Peças</a></li>
	<li <?php if ($categ == 'maquinas' ) echo ' class="active" ';?>><a href="categorias.php?categoria=maquinas&ordenar=valor_diaria asc">Máquinas</a></li>
	<li <?php if ($categ == 'ferramentas' ) echo ' class="active" ';?>><a href="categorias.php?categoria=ferramentas&ordenar=valor_diaria asc">Ferramentas</a></li>
</ul>