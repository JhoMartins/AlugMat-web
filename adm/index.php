<?php
  if (isset($_POST['enviado'])){
      require_once('../includes/conexao.php');
      require_once('../includes/funcoes.php');

      list($check, $data) = check_login($dbc, $_POST['iptLogin'], $_POST['iptSenha']);
	  
      if ($check) {
          session_start();
          $_SESSION['id'] = $data['id'];
          $_SESSION['nome'] = $data['nome'];
          $_SESSION['tipo_usuario'] = $data['tipo_usuario'];
          $_SESSION['status'] = $data['status'];

          $url = absolute_url('../index.php');
          header("Location: $url");
          exit();
      }
      else {
          $erros = $data;
      }

      if (!empty($erros)){
          $saida = '<h2>Erro!</h2>';
		  
          foreach ($erros as $msg) {
              $saida .= " - $msg <br /> \n";
          }
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>AlugMat - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="index.php" method="post">
        <h2 class="form-signin-heading">Login</h2>

        <label for="iptLogin" class="sr-only">Login</label>
        <input type="email" name="iptLogin" id="iptLogin" class="form-control" placeholder="E-mail" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="iptSenha" id="inputPassword" class="form-control" placeholder="Senha" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
		<a href="../index.php" class="btn btn-lg btn-primary btn-block">Cancelar</a>
        <input type="hidden" value="True" name="enviado" />
		
		<?php
			if (isset($saida)) {
				echo "<br /><div class='alert alert-danger'>$saida</div>";
			}
		?>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
