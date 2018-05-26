<div height="100%">
<ul class="nav nav-sidebar">
<?php
	//die($_SESSION['tipo_usuario']);
	if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') {
		echo
		'<li><a href="menu_principal.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Painel de Controle - Início</a></li>
		<li><a href="menu_cliente.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gerenciamento de Usuários</a></li>
		<li class="#"><a href="menu_produto.php"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Gerenciamento de Produtos</a></li>';
	}
?>
</ul>
</div>