<?php
	include_once('../includes/cabecalho.php');
	
	if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
		$id = $_GET['id'];
	}
	else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
		$id = $_POST['id'];
	}
	else {
		//header("Location: usuario_menu.php");
		exit();
	}
	
	require_once('../includes/conexao.php');
	
	if (isset($_POST['enviou'])) {
		
		$erros = array();
		
		//DESCRIÇÃO
		if (empty($_POST['descricao'])) {
			$erros[] = 'Por favor, informe a Descrição.';
		}
		else {
			$descricao = mysqli_real_escape_string($dbc,trim($_POST['descricao']));
		}
		
		//CÓDIGO INTERNO
		if (empty($_POST['cd_interno'])) {
			$erros[] = 'Por favor, informe o Código Interno.';
		}
		else {
			$cd_interno = mysqli_real_escape_string($dbc,trim($_POST['cd_interno']));
		}
		
		//VALOR DA DIÁRIA
		if (empty($_POST['valor_diaria'])) {
			$erros[] = 'Por favor, informe o Valor da Diária.';
		}
		else {
			$valor_diaria = mysqli_real_escape_string($dbc,trim($_POST['valor_diaria']));
		}
		
		//STATUS
		if (isset($_POST['status']) && $_POST['status'] == "") {
			$erros[] = 'Por favor, informe o Status.';
		}
		else {
			$status = mysqli_real_escape_string($dbc,trim($_POST['status']));
		}
		
		//MARCA
		if (isset($_POST['marca']) && $_POST['marca'] == "") {
			$erros[] = 'Por favor, informe a Marca.';
		}
		else {
			$marca = mysqli_real_escape_string($dbc,trim($_POST['marca']));
		}
		
		//CATEGORIA
		if (isset($_POST['categoria']) && $_POST['categoria'] == "") {
			$erros[] = 'Por favor, informe a Categoria.';
		}
		else {
			$categoria = mysqli_real_escape_string($dbc,trim($_POST['categoria']));
		}
		
		//FORNECEDOR
		if (isset($_POST['fornecedor']) && $_POST['fornecedor'] == "") {
			$erros[] = 'Por favor, informe o Fornecedor.';
		}
		else {
			$fornecedor = mysqli_real_escape_string($dbc,trim($_POST['fornecedor']));
		}
		
		//DESTAQUE
		if (isset($_POST['destaque']) && $_POST['destaque'] == "") {
			$erros[] = 'Por favor, informe o se o produto está em Destaque.';
		}
		else {
			$destaque = mysqli_real_escape_string($dbc,trim($_POST['destaque']));
		}
		
		//CARACTERÍSTICAS
		if (trim($_POST['caracteristicas']) != "") {
			$caracteristicas = mysqli_real_escape_string($dbc,$_POST['caracteristicas']);
		}
		else {
			$caracteristicas = NULL;
		}
		
		
		
		//Se não há nenhum erro, inserir registro no banco de dados
		if (empty($erros)) {
			$qry = "update produto set  descricao = '$descricao',
										cd_interno = '$cd_interno',
										valor_diaria = '$valor_diaria',
										status = '$status',
										caracteristicas = '$caracteristicas',
										marca = '$marca',
										categoria = '$categoria',
										destaque = '$destaque',
										fornecedor = '$fornecedor',
										data_alt = NOW()
					where id = $id";
			$res = @mysqli_query($dbc,$qry);
			
			if ($res) {
				$sucesso = "<h1><strong>Sucesso!</strong></h1>
							<p>Seu registro foi incluido com sucesso!</p>
							<p>Aguarde... Redirecionando!</p>";
				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=menu_principal.php'>";
			}
			else {
				$erro = "<h1><strong>Erro no Sistema</strong></h1>
						 <p>Você não pode ser registrado devido a um erro do sistema. Pedimos desculpas por qualquer inconveniente.</p>";
				
				$erro .= '<p>' . mysqli_error($dbc) . '<br /> Query: ' . $q . '</p>';
			}
		}
		
		//Se existem erros, exibir para o usuário
		else {
			$erro = "<h1><strong>Erro!</strong></h1>
					 <p>Ocorreram o(s) seguinte(s) erro(s):<br />";
					 
			foreach ($erros as $msg) {
				$erro .= " - $msg <br /> \n";
			}
			$erro .= "</p><p>Por favor, tente novamente.</p>";
		}
	}
	
	//Pesquisa para exibir o registro para alteração
	$qry = "select * from produto where id = $id";
	$res = @mysqli_query($dbc, $qry);
  
	if (mysqli_num_rows($res) == 1) {
		$row = mysqli_fetch_array($res, MYSQLI_NUM);
	
	if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; 
	
	if (isset($sucesso)) echo "<div class='alert alert-success'>$sucesso</div>";
?>


	<div id="main" class="container-fluid">
		<h3 class="page-header">Cadastro de Produto</h3>
		<form method="post" action="">
		  <div id="actions"> 
			<div class="form group col-md-6">
				<label>* Descrição</label>
				<input type="text" name="descricao" maxlength="50" class="form-control" value="<?php echo $row[1]; ?>">
			</div>

			<div class="form group col-md-4">
				<label>* Código Interno</label>
				<input type="text" name="cd_interno" maxlength="10" class="form-control" value="<?php echo $row[2]; ?>">
			</div>

			<div class="form group col-md-2">
				<label>* Valor da diária</label>
				<input type="text" name="valor_diaria" maxlength="8" class="form-control" value="<?php echo $row[3]; ?>">
			</div>

			<div class="form group col-md-2">
			<br />
				<label for="">* Status</label>
				<select class="form-control" name="status">
					<option value="">Selecione</option>
					<option value="S" <?php if ($row[4] == "S") echo "selected"; ?>>Ativo</option>
					<option value="N" <?php if ($row[4] == "N") echo "selected"; ?>>Inativo</option>
				</select>
			</div>

		

			<div class="form-group col-md-2" >
			<br />
			<label for="sel1">* Marca:</label>
			<select class="form-control" id="sel1" name="marca">
				<option value="">Selecione</option>
				<option value="Bosh" <?php if ($row[7] == "Bosh") echo "selected"; ?>>Bosh</option>
				<option value="3M" <?php if ($row[7] == "3M") echo "selected"; ?>>3M</option>
				<option value="Bracol" <?php if ($row[7] == "Bracol") echo "selected"; ?>>Bracol</option>
			</select>
			</div>

			<div class="form-group col-md-2" >
			<br />
				<label for="sel1">* Categoria:</label>
				<select class="form-control" id="sel1" name="categoria">
					<option value="">Selecione</option>
					<option value="pecas" <?php if ($row[8] == "pecas") echo "selected"; ?>>Peças</option>
					<option value="maquinas" <?php if ($row[8] == "maquinas") echo "selected"; ?>>Máquinas</option>
					<option value="ferramentas" <?php if ($row[8] == "ferramentas") echo "selected"; ?>>Ferramentas</option>
				</select>
			</div>

			<div class="form-group col-md-4" >
				<br />
				<label for="sel1">* Fornecedor:</label>
				<select class="form-control" id="sel1" name="fornecedor">
					<option value="">Selecione</option>
					<option value="fornecedor 1" <?php if ($row[9] == "fornecedor 1") echo "selected"; ?>>Fornecedor 1</option>
					<option value="fornecedor 2" <?php if ($row[9] == "fornecedor 2") echo "selected"; ?>>Fornecedor 2</option>
					<option value="fornecedor 3" <?php if ($row[9] == "fornecedor 3") echo "selected"; ?>>Fornecedor 3</option>
				</select>
			</div>
			
			<div class="form-group col-md-2" >
				<br/>
				<label for="sel1">* Destaque:</label>
				<select class="form-control" id="sel1" name="destaque">
					<option value="">Selecione</option>
					<option value="S" <?php if ($row[14] == "S") echo "selected"; ?>>Sim</option>
					<option value="N" <?php if ($row[14] == "N") echo "selected"; ?>>Não</option>
				</select>
			</div>

				 <div class="form-group col-md-12">
    			<label for="exampleFormControlTextarea1">Caracteristicas</label>
    			<textarea class="form-control" id="exampleFormControlTextarea1" rows="7" name="caracteristicas"><?php echo $row[6]; ?></textarea>
  			 </div>
			
			<div class="col-md-12">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="menu_principal.php" class="btn btn-default">Cancelar</a>
			<input type="hidden" name="enviou" value="True" />
			<input type="hidden" name="id" value="<?php echo $row[0]; ?>" />
			</div>
			</div>
		</form>
	
		
	</div>
		<?php
		include_once('../includes/rodape.php');
		?>
				
</html>

<?php
  }
  
  mysqli_close($dbc);
  
  include_once('../includes/rodape.php');
?>	