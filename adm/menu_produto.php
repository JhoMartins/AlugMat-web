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

  $q = "SELECT id, descricao FROM produto ORDER BY $order_by LIMIT $inicio, $exiba";
  $r = @mysqli_query($dbc, $q);

  if (mysqli_num_rows($r) > 0) {
      $saida = '<div class="table-responsive col-md-12">
      <table class="table table-striped">
      <thead>
        <tr>
          <th width="10%"><strong>
            <a href="menu_produto?ordem=id">Código</a></strong></th>
          <th width="10%"><strong>
            <a href="menu_produto?ordem=d">Descrição</a></strong></th>
        </tr>
      </thead> <tbody>';

      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
          $saida .= '<tr>
          <td>' . $row['id'] . '</td>
          <td>' . $row['descricao'] . '</td>
          <td class="actions">
            <a href="alt_produto.php?id=' . $row['id'] . '" class="btn btn-xs btn-warning">Editar</a>
            <a href="exc_produto.php?id=' . $row['id'] . '" class="btn btn-xs btn-danger">Excluir</a>
          </td>
          </tr>';
      }
      $saida .= '</tbody></table></div>';
  } else {
        $saida = "<div class='alert alert-warning'>
        Sua pesquisa por <strong>$where</strong> 
        não encontrou nenhum resultado.<br />";
        $saida .= "<strong>Dicas</strong><br />";
        $saida .= "- Tente palavras menos específicas<br />";
        $saida .= "- Tente palavras chaves diferentes<br />";
        $saida .= "- Confira a ortografia das palavras
        e se elas foram acentuadas corretamente.<br />";
  }
?>

<div id="main" class="container-fluid">
  <div id="top" class="row">
	
	<div class="col-md-3">
	  <h2>Usuários</h2>
	</div>
	
	<div class="col-md-6">
	  <div class="input-group h2">
	    <input class="form-control"
			id="busca"
			type="text"
			placeholder="Pesquisa de miniatura por Nome" />
		<span class="input-group-btn">
		 <a href="#" 
		    onclick="this.href='menu_produto.php?q='+
			   document.getElementById('busca').value"
		 class="btn btn-primary">
		<span class="glyphicon glyphicon-search">
		</span>
		 </a>
		</span>
	  </div>
	</div>
	
	<div class="col-md-3">
	  <a href="usuario_cad.php" 
		class="btn btn-primary pull-right h2">
		Inserir Miniatura</a>
	</div>
  </div>
</div>

<hr />

<div id="list" class="row">
  <?php echo $saida; ?>
</div>

<!-- <div id="botton" class="row">
  <ul class="pagination">
    <?php if (isset($pag)) {echo $pag;} ?>
  </ul>
</div> -->
  

<?php
  include_once('../includes/rodape.php');
?>