<?php
	$categ = isset($_GET['cat_nome']) ? $_GET['cat_nome'] : 'Home';
?>

<ul class="nav nav-tabs" role="tablist">
	<li <?php if ($categ == 'Home') echo 'class="active"'?>><a href="index.php">Home</a></li>
	<li <?php if ($categ == 'Automóveis') echo 'class="active"'?>><a href="categorias.php?cat_id=2&cat_nome=Automóveis&ordenar=preco ASC">Automóveis</a></li>
	<li <?php if ($categ == 'Aviões') echo 'class="active"'?>><a href="categorias.php?cat_id=6&cat_nome=Aviões&ordenar=preco ASC">Aviões</a></li>
	<li <?php if ($categ == 'Caminhões') echo 'class="active"'?>><a href="categorias.php?cat_id=4&cat_nome=Caminhões&ordenar=preco ASC">Caminhões</a></li>
	<li <?php if ($categ == 'Máquinas Pesadas') echo 'class="active"'?>><a href="categorias.php?cat_id=3&cat_nome=Máquinas Pesadas&ordenar=preco ASC">Máquinas Pesadas</a></li>
	<li <?php if ($categ == 'Militares') echo 'class="active"'?>><a href="categorias.php?cat_id=7&cat_nome=Militares&ordenar=preco ASC">Militares</a></li>
	<li <?php if ($categ == 'Motocicletas') echo 'class="active"'?>><a href="categorias.php?cat_id=5&cat_nome=Motocicletas&ordenar=preco ASC">Motocicletas</a></li>
	<li <?php if ($categ == 'Ônibus') echo 'class="active"'?>><a href="categorias.php?cat_id=1&cat_nome=Ônibus&ordenar=preco ASC">Ônibus</a></li>
</ul>