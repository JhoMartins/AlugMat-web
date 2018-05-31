<?php
  $titulo = "AlugMat - Produtos";
  $link = "Produtos";

  include_once('../includes/cabecalho.php');

  require_once('../includes/conexao.php');

  require_once('../includes/funcoes.php');

  authorize_user();

  $exiba = 5;

  $where = mysqli_real_escape_string($dbc, trim(isset($_GET['q'])) ? $_GET['q'] : '');

  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
      $pagina = $_GET['p'];
  } else {
    $q = "SELECT COUNT(id) FROM produto WHERE descricao like '%$where%'";
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
      case 'cd':
        $order_by = 'cd_interno';
        break;
      case 'desc':
        $order_by = 'descricao';
        break;
	  case 'marca':
        $order_by = 'marca';
        break;
	  case 'categoria':
        $order_by = 'categoria';
        break;
	  case 'fornecedor':
        $order_by = 'fornecedor';
        break;
      case 'd':
        $order_by = 'valor_diaria';
        break;
      case 'disp':
        $order_by = 'disponivel';
        break;
      case 'nota':
        $order_by = 'nota';
        break;
      default:
        $order_by = 'id';
        $ordem = 'id';
        break;
  }

  $q = "SELECT id, descricao, cd_interno, valor_diaria, disponivel, nota, marca, categoria, fornecedor FROM produto WHERE descricao LIKE '%$where%' ORDER BY $order_by LIMIT $inicio, $exiba";
  $r = @mysqli_query($dbc, $q);

  if (mysqli_num_rows($r) > 0) {
      $saida = '<div class="table-responsive col-md-12">
      <table class="table table-striped">
      <thead>
        <tr>
          <th width="5%"><strong>
            <a href="menu_produto.php?ordem=id">ID</a></strong></th>
          <th width="10%"><strong>
            <a href="menu_produto.php?ordem=cd">Cód. Interno</a></strong></th>
          <th width="20%"><strong>
            <a href="menu_produto.php?ordem=desc">Descrição</a></strong></th>
		  <th width="10%"><strong>
            <a href="menu_produto.php?ordem=marca">Marca</a></strong></th>
		  <th width="10%"><strong>
            <a href="menu_produto.php?ordem=categoria">Categoria</a></strong></th>
		  <th width="16%"><strong>
            <a href="menu_produto.php?ordem=fornecedor">Fornecedor</a></strong></th>
          <th width="9%"><strong>
            <a href="menu_produto.php?ordem=d">Valor Diária</a></strong></th>
          <th width="5%"><strong>
            <a href="menu_produto.php?ordem=disp">Disp.</a></strong></th>
          <th width="5%"><strong>
            <a href="menu_produto.php?ordem=nota">Nota</a></strong></th>
          <th></th>
        </tr>
      </thead> <tbody>';

	  
      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		  
		  if ($row['categoria'] == 'Peças') {
		  $cat = 'Peças';
		  }
		  else if ($row['categoria'] == 'Máquinas') {
			  $cat = 'Máquinas';
		  }
		  else {
			  $cat = 'Ferramentas';
		  }
		  
          $saida .= '<tr>
          <td>' . $row['id'] . '</td>
          <td>' . $row['cd_interno'] . '</td>
          <td>' . $row['descricao'] . '</td>
		  <td>' . $row['marca'] . '</td>
		  <td>' . $cat . '</td>
		  <td>' . $row['fornecedor'] . '</td>
          <td>R$ ' . number_format($row['valor_diaria'],2,',','.') . '</td>
          <td>' . $row['disponivel'] . '</td>
          <td>' . $row['nota'] . '</td>
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

  if ($pagina > 1) {
    $pag = '';
    $pagina_correta = ($inicio/$exiba) + 1;

    if ($pagina_correta != 1){
      $pag .= '<li class="prior">
      <a href="menu_produto.php?s=' . ($inicio - $exiba) . '&p=' . $pagina . '&ordem=' . $ordem . '">Anterior</a><li>';
    } else {
      $pag .= '<li class="disabled"><a>Anterior</a></li>';
    }

    for ($i = 1; $i <= $pagina; $i++) {
		  if ($i != $pagina_correta) {
			  $pag .= '<li>
		    <a href="menu_produto.php?s=' . ($exiba * ($i - 1)) . '&p=' . $pagina . '&ordem=' . $ordem . '">' . $i . '</a></li>';
		  } else {
			  $pag .= '<li class="disabled"><a>' .
		    $i . '</a></li>';
		  }
    }
    
    if ($pagina_correta != $pagina) {
		  $pag .= '<li class="next"> <a href="menu_produto.php?s=' . ($inicio + $exiba) . '&p=' . $pagina . '&ordem=' .
		  $ordem . '">Próximo</a></li>';
	  } else {
		  $pag .= '<li class="disabled"><a>Próximo</a></li>';
	  }
  }
?>

<div id="main" class="container-fluid">
  <div id="top" class="row">
	
	<div class="col-md-3">
	  <h2>Produtos</h2>
	</div>
	
	<div class="col-md-6">
	  <div class="input-group h2">
	    <input class="form-control"
			id="busca"
			type="text"
			placeholder="Pesquisa de produto por Nome" />
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
	  <a href="cad_produto.php" 
		class="btn btn-primary pull-right h2">
		Inserir Produto</a>
	</div>
  </div>
</div>

<hr />

<div id="list" class="row">
  <?php echo $saida; ?>
</div>

<div id="botton" class="row">
  <ul class="pagination">
    <?php if (isset($pag)) {echo $pag;} ?>
  </ul>
</div>
  

<?php
  include_once('../includes/rodape.php');
?>