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

  $titulo = 'Desconectado!';
  require_once('../includes/cabecalho.php');

  echo "<h1>Desconectado!>/h1>
  <p>Você agora está desconectado, {$_COOKIE['nome']}!</p>"

  require_once('../includes/rodape.php')
?>