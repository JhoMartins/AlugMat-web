<?php
  $titulo = "AlugMat - Produtos";
  $link = "Produtos";

  include_once('../includes/cabecalho.php');

  require_once('../includes/conexao.php');

  $exiba = 3;

  $where = mysqli_real_escape_string($dbc, trim(isset($_GET['q'])) ? $_GET['q'] : '');

  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
      $pagina = $_GET['p'];
  } else {
    $q = "SELECT COUNT(id) FROM produto";
    $r = @mysqli_query($dbc, $q);
    $row = @mysqli_fetch_array($r, MYSQLI_NUM);
    $qtde = $row[0];

    if($qtde > $exiba) {
        $pagina = ceil($qtde/$exiba);
    } else {
        $pagina = 1;
    }
  }

  if (isset($_GET['s']) && is_numeric($_GET['s'])) {
      $inicio = $_GET['s'];
  } else {
      $inicio = 0;
  }

  $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id';

  switch($ordem) {
      case 'id':
        $order_by = 'id';
        break;
      default:
        $order_by = 'id';
        $ordem = 'id';
        break;
  }

  $q = "SELECT * FROM produto ORDER BY $order_by LIMIT $inicio, $exiba";
  $r = @mysqli_query($dbc, $q);

  if (mysqli_num_rows($r) > 0) {
      
  }
?>