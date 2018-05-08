<ul class="nav nav-sidebar">
<?php
	//die($_SESSION['tipo_usuario']);
	if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') {
		echo
		'<li><a href="menu_principal.php">Painel de Controle - Início</a></li>
		<li><a href="menu_cliente.php">Gerenciamento de Usuários</a></li>
		<li class="#"><a href="menu_produto.php">Gerenciamento de Produtos</a></li>';
	}
?>
</ul>