<?php
  session_start();
  if (!isset($_SESSION['id'])) {
    require_once('../includes/funcoes.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
  }
  else {
   $_SESSION = array();
   session_destroy();
  }
/*
  $titulo = 'Desconectado!';
  require_once('../includes/cabecalho_site.php');

  echo "<div class='alert alert-success'>
		<h1><strong>Sucesso!</strong></h1>							
 	    <p>Você agora está desconectado, {$_COOKIE['nome']}!</p>
 	    <p>Aguarde... Redirecionando!</p>
		</div>";

  require_once('../includes/rodape.php');
*/
  echo "<meta HTTP-EQUIV='refresh' CONTENT='0; URL=../index.php'>";

?>