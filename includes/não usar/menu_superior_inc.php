<ul class="nav navbar-nav">
	<li><a href="pedidos.php">Meus Pedidos</a></li>
	<li><a href="login.php?cadastro=S">Meu Cadastro</a></li>
	<li><a href="cesta.php">Meu Carrinho
	(<?php
		if (!isset($_SESSION['total_itens'])) {
			echo "vazio";
		}
		if (isset($_SESSION['total_itens'])) {
			
			if ($_SESSION['total_itens'] == 0) {
				echo "vazio";
			}
			else if ($_SESSION['total_itens'] == 1) {
				echo $_SESSION['total_itens'] . " produto";
			}
			else {
				echo $_SESSION['total_itens'] . " produtos";
			}
		}
	?>)
	</a></li>
</ul>
	