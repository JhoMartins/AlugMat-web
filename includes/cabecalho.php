<?php
	if (!isset($_SESSION['id'])) {
		session_start();
	}
?>
<!DOCTYPE html>
<html lang="eng">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo "Alugmat - " . $titulo; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../includes/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="../js/masks.js"></script>
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Alugmat - Aluguel de Materiais e Ferramentas</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
		  <?php if (!isset($_SESSION['id'])) { ?>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="../index.php">Home</a></li>
			  </ul>
		  <?php } else {?>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="../index.php">Home</a></li>
				<li><a href="../minhas_reservas.php"> Minhas Reservas </a></li>
				<li><a href="alt_cliente.php?id=<?= $_SESSION['id'] ?>"> Meu Cadastro </a></li>
			    <li><a href="../cesta.php"> Meu Carrinho 
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
							echo $_SESSION['total_itens'] . " produto";
						}
						else
						{
							echo $_SESSION['total_itens'] . " produtos";
						}
					}

				?>)</a></li>
				<li><a href="logout.php">Sair</a></li>
			  </ul>
		  <?php } ?>
		  
		  
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
  <div class="container-fluid">
  <div class="row">
  <div class="col-sm-3 col-md-2 
	sidebar">
    <?php include_once('../includes/menu_lateral.php'); ?>
  </div>
  
  <div class="col-sm-9 
  col-sm-offset-3 
  col-md-10 
  col-md-offset-2 main">