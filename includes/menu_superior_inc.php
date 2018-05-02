
<?php
	if (!isset($_SESSION['id'])) {
?>
<ul class="nav navbar-nav">
	<li><a href="adm/cad_cliente.php">Cadastre-se</a></li>
	<li><a href="adm/index.php?">Login</a></li>
	
	</a></li>
</ul>
<?php
	} else {
?>
<ul class="nav navbar-nav">
	<li><a href="pedidos.php"> Minhas Reservas </a></li>
	<li><a href="login.php?cadastro=s"> Meu Cadastro </a></li>
	<li><a href="cesta.php"> Meu Carrinho 
	(<?php if (!isset($_SESSION['total_itens'])) 
		{
			echo "vazio";
		}

		if (isset($_SESSION['total_itens']))
		{
			if ($_SESSION['total_itens'] == 0)
			{
				echo "vazio";
			}
			else if ($_SESSION['total_itens'] == 1)
			{
				echo $_SESSION['total_itens'] . "produto";
			}
			else
			{
				echo $_SESSION['total_itens'] . "produtos";
			}
		}

	?>)</a></li>
	<li><a href="adm/logout.php">Sair</a></li>
</ul>
	<?php } ?>