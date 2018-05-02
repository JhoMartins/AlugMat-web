<?php
	include_once('../includes/cabecalho.php');
	
	if (isset($_POST['enviou'])) {
		require_once('../includes/conexao.php');
		
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
		
		//CARACTERÍSTICAS
		if (trim($_POST['caracteristicas']) != "") {
			$caracteristicas = mysqli_real_escape_string($dbc,$_POST['caracteristicas']);
		}
		else {
			$caracteristicas = NULL;
		}
		
		
		
		//Se não há nenhum erro, inserir registro no banco de dados
		if (empty($erros)) {
			$qry = "insert into produto (
										descricao, 
										cd_interno, 
										valor_diaria, 
										status, 
										disponivel, 
										caracteristicas, 
										marca, 
										categoria, 
										fornecedor, 
										data_inc
								) values (
										'$descricao',
										'$cd_interno',
										'$valor_diaria',
										'$status',
										'S',
										'$caracteristicas',
										'$marca',
										'$categoria',
										'$fornecedor',
										NOW())";
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
		
		mysqli_close($dbc);
	}
	
	if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; 
	
	if (isset($sucesso)) echo "<div class='alert alert-success'>$sucesso</div>";
?>


	<div id="main" class="container-fluid">
		<h3 class="page-header">Cadastro de Produto</h3>
		<form method="post" action="cad_produto.php">
		  <div id="actions" class="row"> 
			
			<div class="form group col-md-5">
				<label>* Descrição</label>
				<input type="text" name="descricao" maxlength="50" class="form-control" value="<?php if (isset($_POST['descricao'])) echo $_POST['descricao']; ?>">
			</div>

			<div class="form group col-md-4">
				<label>* Código Interno</label>
				<input type="text" name="cd_interno" maxlength="10" class="form-control" value="<?php if (isset($_POST['cd_interno'])) echo $_POST['cd_interno']; ?>">
			</div>

			<div class="form group col-md-3">
				<label>* Valor da diária</label>
				<input type="text" name="valor_diaria" maxlength="8" class="form-control" value="<?php if (isset($_POST['valor_diaria'])) echo $_POST['valor_diaria']; ?>">
			</div>


			<div class="form group col-md-3">
				<br/>
				<label for="status">* Status</label>
				<select class="form-control" name="status">
					<option value="">Selecione</option>
					<option value="S" <?php if (isset($_POST['status']) && $_POST['status'] == "S") echo "selected"; ?>>Ativo</option>
					<option value="N" <?php if (isset($_POST['status']) && $_POST['status'] == "N") echo "selected"; ?>>Inativo</option>
				</select>
			</div>
		

			<div class="form-group col-md-3" >
				<br/>
			<label for="sel1">* Marca:</label>
			<select class="form-control" id="sel1" name="marca">
				<option value="">Selecione</option>
				<option value="Bosh" <?php if (isset($_POST['marca']) && $_POST['marca'] == "Bosh") echo "selected"; ?>>Bosh</option>
				<option value="3M" <?php if (isset($_POST['marca']) && $_POST['marca'] == "3M") echo "selected"; ?>>3M</option>
				<option value="Bracol" <?php if (isset($_POST['marca']) && $_POST['marca'] == "Bracol") echo "selected"; ?>>Bracol</option>
			</select>
			</div>

			<div class="form-group col-md-3" >
				<br/>
				<label for="sel1">* Categoria:</label>
				<select class="form-control" id="sel1" name="categoria">
					<option value="">Selecione</option>
					<option value="pecas" <?php if (isset($_POST['categoria']) && $_POST['categoria'] == "pecas") echo "selected"; ?>>Peças</option>
					<option value="maquinas" <?php if (isset($_POST['categoria']) && $_POST['categoria'] == "maquinas") echo "selected"; ?>>Máquinas</option>
					<option value="ferramentas" <?php if (isset($_POST['categoria']) && $_POST['categoria'] == "ferramentas") echo "selected"; ?>>Ferramentas</option>
				</select>
			</div>

			<div class="form-group col-md-3" >
				<br/>
				<label for="sel1">* Fornecedor:</label>
				<select class="form-control" id="sel1" name="fornecedor">
					<option value="">Selecione</option>
					<option value="fornecedor 1" <?php if (isset($_POST['fornecedor']) && $_POST['fornecedor'] == "fornecedor 1") echo "selected"; ?>>Fornecedor 1</option>
					<option value="fornecedor 2" <?php if (isset($_POST['fornecedor']) && $_POST['fornecedor'] == "fornecedor 2") echo "selected"; ?>>Fornecedor 2</option>
					<option value="fornecedor 3" <?php if (isset($_POST['fornecedor']) && $_POST['fornecedor'] == "fornecedor 3") echo "selected"; ?>>Fornecedor 3</option>
				</select>
			</div>

				 <div class="form-group col-md-12">
    				<label for="exampleFormControlTextarea1">Caracteristicas</label>
    				<textarea class="form-control" id="exampleFormControlTextarea1" rows="7" name="caracteristicas"><?php if (isset($_POST['caracteristicas'])) echo $_POST['caracteristicas'];?></textarea>
    				<hr />
  			 	</div>

  
			
			<div class="col-md-12">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="index.html" class="btn btn-default">Cancelar</a>
			<input type="hidden" name="enviou" value="True" />
			</div>
			</div>

		</form>
				<?php
		include_once('../includes/rodape.php');
		?>
	

				
</html>