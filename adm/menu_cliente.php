<?php
  $titulo = "AlugMat - Usuários";
  $link = "Usuários";

  include_once('../includes/cabecalho.php');

  require_once('../includes/conexao.php');

  $exiba = 5;

  $where = mysqli_real_escape_string($dbc, trim(isset($_GET['q'])) ? $_GET['q'] : '');

  if (isset($_GET['p']) && is_numeric($_GET['p'])) {
      $pagina = $_GET['p'];
  } else {
    $qry = "SELECT COUNT(id) FROM cliente WHERE nome like '%$where%'";
    $res = @mysqli_query($dbc, $qry);
    $row = @mysqli_fetch_array($res, MYSQLI_NUM);
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
	  case 'nome':
        $order_by = 'nome';
        break;
	  case 'cpf_cnpj':
        $order_by = 'cpf, cnpj';
        break;
	  case 'rg_ie':
        $order_by = 'rg, ie';
        break;
      case 'cidade':
        $order_by = 'cidade';
        break;
	  case 'telefone':
        $order_by = 'telefone';
        break;
	  case 'celular':
        $order_by = 'celular';
        break;
      case 'status':
        $order_by = 'status';
        break;
      case 'tipo_usuario':
        $order_by = 'tipo_usuario';
        break;
  }

  $q = "SELECT id, 
			   nome, 
			   (case
			    when cpf is null then cnpj
			    else cpf
			    end) as cpf_cnpj,
			   (case
			    when rg is null then ie
			    else rg
			    end) as rg_ie,
			   cidade,
			   telefone,
			   celular,
			   (case
			    when status = 'S' then 'Ativo'
				when status = 'N' then 'Inativo'
				else ''
				end) as status,
			   tipo_usuario
		FROM cliente
		WHERE nome like '%$where%'
		ORDER BY $order_by LIMIT $inicio, $exiba";
		//die("<pre>".$q."</pre>");
  $r = @mysqli_query($dbc, $q);

  if (mysqli_num_rows($r) > 0) {
      $saida = '<div class="table-responsive col-md-12">
      <table class="table table-striped">
      <thead>
        <tr>
          <th width="3%"><strong>
            <a href="menu_cliente.php?ordem=id">ID</a></strong></th>
          <th width="23%"><strong>
            <a href="menu_cliente.php?ordem=nome">Nome</a></strong></th>
          <th width="13%"><strong>
            <a href="menu_cliente.php?ordem=cpf_cnpj">CPF/CNPJ</a></strong></th>
          <th width="5%"><strong>
            <a href="menu_cliente.php?ordem=rg_ie">RG/IE</a></strong></th>
          <th width="10%"><strong>
            <a href="menu_cliente.php?ordem=cidade">Cidade</a></strong></th>
		  <th width="10%"><strong>
            <a href="menu_cliente.php?ordem=telefone">Telefone</a></strong></th>
		  <th width="10%"><strong>
            <a href="menu_cliente.php?ordem=celular">Celular</a></strong></th>
		  <th width="5%"><strong>
            <a href="menu_cliente.php?ordem=status">Status</a></strong></th>
		  <th width="5%"><strong>
            <a href="menu_cliente.php?ordem=tipo_usuario">Tipo</a></strong></th>
        </tr>
      </thead> <tbody>';

      while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
          $saida .= '<tr>
          <td>' . $row['id'] . '</td>
          <td>' . $row['nome'] . '</td>
          <td>' . $row['cpf_cnpj'] . '</td>
          <td>' . $row['rg_ie'] . '</td>
          <td>' . $row['cidade'] . '</td>
		  <td>' . $row['telefone'] . '</td>
		  <td>' . $row['celular'] . '</td>
		  <td>' . $row['status'] . '</td>
		  <td>' . $row['tipo_usuario'] . '</td>
          <td class="actions">
            <a href="alt_cliente.php?id=' . $row['id'] . '" class="btn btn-xs btn-warning">Editar</a>
            <a href="exc_cliente.php?id=' . $row['id'] . '" class="btn btn-xs btn-danger">Excluir</a>
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

    if ($pagina_correta !=1){
      $pag .= '<li class="prior">
      <a href="menu_cliente.php?s=' . ($inicio - $exiba) . '&p=' . $pagina . '&ordem=' . $ordem . '">Anterior</a><li>';
    } else {
      $pag .= '<li class="disabled"><a>Anterior</a></li>';
    }

    for ($i = 1; $i <= $pagina; $i++) {
		  if ($i != $pagina_correta) {
			  $pag .= '<li>
		    <a href="menu_cliente.php?s=' . ($exiba * ($i - 1)) . '&p=' . $pagina . '&ordem=' . $ordem . '">' . $i . '</a></li>';
		  } else {
			  $pag .= '<li class="disabled"><a>' .
		    $i . '</a></li>';
		  }
    }
    
    if ($pagina_correta != $pagina) {
		  $pag .= '<li class="next"> <a href="menu_cliente.php?s=' . ($inicio + $exiba) . '&p=' . $pagina . '&ordem=' .
		  $ordem . '">Próximo</a></li>';
	  } else {
		  $pag .= '<li class="disabled"><a>Próximo</a></li>';
	  }
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
			placeholder="Pesquisa de Usuário por Nome" />
		<span class="input-group-btn">
		 <a onclick="this.href='menu_cliente.php?q='+
			   document.getElementById('busca').value"
		 class="btn btn-primary">
		<span class="glyphicon glyphicon-search">
		</span>
		 </a>
		</span>
	  </div>
	</div>
	
	<div class="col-md-3">
	  <a href="cad_cliente.php" 
		class="btn btn-primary pull-right h2">
		Inserir Usuário</a>
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