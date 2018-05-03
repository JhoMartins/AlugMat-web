<?php
	include_once('../includes/cabecalho.php');
	
	if (isset($_POST['enviou'])) {
		require_once('../includes/conexao.php');
		
		$erros = array();
		
		//TIPO DE PESSOA
		if (isset($_POST['tipo_pessoa']) && $_POST['tipo_pessoa'] == "") {
			$erros[] = 'Por favor, informe o Tipo de Pessoa.';
		}
		else {
			$tipo_pessoa = mysqli_real_escape_string($dbc,$_POST['tipo_pessoa']);
		}
		//die("Tipo de Pessoa: " . $_POST['tipo_pessoa']);
		
		//NOME
		if (empty($_POST['nome'])) {
			$erros[] = 'Por favor, informe o Nome.';
		}
		else {
			$nome = mysqli_real_escape_string($dbc,trim($_POST['nome']));
		}
		
		//CPF
		if ($_POST['tipo_pessoa'] == 'F' && empty($_POST['cpf'])) {
			$erros[] = 'Por favor, informe o CPF.';
		}
		else {
			$cpf = (!empty($_POST['cpf'])) ? mysqli_real_escape_string($dbc,trim($_POST['cpf'])) : NULL;
		}
		
		//RG
		if ($_POST['tipo_pessoa'] == 'F' && empty($_POST['rg'])) {
			$erros[] = 'Por favor, informe o RG.';
		}
		else {
			$rg = (!empty($_POST['rg'])) ? mysqli_real_escape_string($dbc,trim($_POST['rg'])) : NULL;
		}
		
		//CNPJ
		if ($_POST['tipo_pessoa'] == 'J' && empty($_POST['cnpj'])) {
			$erros[] = 'Por favor, informe o CNPJ.';
		}
		else {
			$cnpj = (!empty($_POST['cnpj'])) ? mysqli_real_escape_string($dbc,trim($_POST['cnpj'])) : NULL;
		}
		
		//IE
		if ($_POST['tipo_pessoa'] == 'J' && empty($_POST['ie'])) {
			$erros[] = 'Por favor, informe a IE.';
		}
		else {
			$ie = (!empty($_POST['ie'])) ? mysqli_real_escape_string($dbc,trim($_POST['ie'])) : NULL;
		}
		
		//TIPO DE LOGRADOURO
		if (empty($_POST['logradouro'])) {
			$erros[] = 'Por favor, informe o Tipo de Logradouro.';
		}
		else {
			$logradouro = mysqli_real_escape_string($dbc,trim($_POST['logradouro']));
		}
		
		//LOGRADOURO
		if (empty($_POST['nome_logradouro'])) {
			$erros[] = 'Por favor, informe o Logradouro.';
		}
		else {
			$nome_logradouro = mysqli_real_escape_string($dbc,trim($_POST['nome_logradouro']));
		}
		
		//NÚMERO
		if (empty($_POST['num'])) {
			$erros[] = 'Por favor, informe o Número.';
		}
		else if (!is_numeric($_POST['num'])) {
			$erros[] = 'Formato do Número inválido. Por favor, digite apenas números nesse campo.';
		}
		else {
			$num = mysqli_real_escape_string($dbc,trim($_POST['num']));
		}
		
		//COMPLEMENTO
		if (!empty($_POST['complemento'])) {
			$complemento = (isset($_POST['complemento'])) ? mysqli_real_escape_string($dbc,trim($_POST['complemento'])) : NULL;
		}
		
		//BAIRRO
		if (empty($_POST['bairro'])) {
			$erros[] = 'Por favor, informe o Bairro.';
		}
		else {
			$bairro = mysqli_real_escape_string($dbc,trim($_POST['bairro']));
		}
		
		//CIDADE
		if (empty($_POST['cidade'])) {
			$erros[] = 'Por favor, informe a Cidade.';
		}
		else {
			$cidade = mysqli_real_escape_string($dbc,trim($_POST['cidade']));
		}
		
		//UF
		if (empty($_POST['estado'])) {
			$erros[] = 'Por favor, informe o Estado.';
		}
		else {
			$estado = mysqli_real_escape_string($dbc,trim($_POST['estado']));
		}
		
		//TELEFONE E CELULAR
		if (empty($_POST['telefone']) && empty($_POST['celular'])) {
			$erros[] = 'Por favor, informe ao menos um número de Telefone ou Celular.';
		}
		else {
			//TELEFONE
			if (!empty($_POST['telefone'])) {
				$telefone = mysqli_real_escape_string($dbc,trim($_POST['telefone']));
			}
			else {
				$telefone = NULL;
			}
			//CELULAR
			if (!empty($_POST['celular'])) {
				$celular = mysqli_real_escape_string($dbc,trim($_POST['celular']));
			}
			else {
				$celular = NULL;
			}
		}
		
		//E-MAIL
		if (empty($_POST['email'])) {
			$erros[] = 'Por favor, informe o E-mail.';
		}
		else {
			$email = mysqli_real_escape_string($dbc,trim($_POST['email']));
		}
		
		//SENHA
		if (!empty($_POST['senha'])) {
			if ($_POST['senha'] != $_POST['senhac']) {
				$erros[] = 'As senhas digitadas não correspondem. Por favor, informe duas senhas iguais nos campos "Senha" e "Confirmar Senha".';
			}
			else {
				$senha = mysqli_real_escape_string($dbc, trim($_POST['senha']));
			}
		}
		else {
			$erros[] = 'Por favor, informe e confirme a Senha.';
		}
		
		
		
		//Se não há nenhum erro, inserir registro no banco de dados
		if (empty($erros)) {
			$qry = "insert into cliente (
										tipo_pessoa, 
										nome, 
										cpf, 
										rg, 
										cnpj, 
										ie, 
										logradouro, 
										nome_logradouro, 
										num, 
										complemento, 
										bairro, 
										cidade, 
										estado, 
										telefone, 
										celular,
										email,
										senha,
										data_inc, 
										tipo_usuario
								) values (
										'$tipo_pessoa',
										'$nome',
										'$cpf',
										'$rg',
										'$cnpj',
										'$ie',
										'$logradouro',
										'$nome_logradouro',
										'$num',
										'$complemento',
										'$bairro',
										'$cidade',
										'$estado',
										'$telefone',
										'$celular',
										'$email',
										SHA1('bd_alugmat'.$senha),
										NOW(),
										'USU')";
			$res = @mysqli_query($dbc,$qry);
			
			if ($res) {
				$sucesso = "<h1><strong>Sucesso!</strong></h1>
							<p>Seu registro foi incluido com sucesso!</p>
							<p>Aguarde... Redirecionando!</p>";
				
				echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=../index.php'>";
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
		<h3 class="page-header">Cadastro de Usuário</h3>
		
		<script>
		function tipopessoa(e) { 
					if(e.value == "F") {
						document.getElementById("cpf").disabled = false;
						document.getElementById("rg").disabled = false;
						document.getElementById("cnpj").disabled = true;
						document.getElementById("ie").disabled = true;
						document.getElementById("cnpj").value = "";
						document.getElementById("ie").value = "";
					} if(e.value == "J") {
						document.getElementById("cnpj").disabled = false;
						document.getElementById("ie").disabled = false;
						document.getElementById("cpf").disabled = true;
						document.getElementById("rg").disabled = true;
						document.getElementById("cpf").value = "";
						document.getElementById("rg").value = "";
					}
					if (e.value == "") {
						document.getElementById("cnpj").disabled = true;
						document.getElementById("ie").disabled = true;
						document.getElementById("cpf").disabled = true;
						document.getElementById("rg").disabled = true;
						document.getElementById("cnpj").value = "";
						document.getElementById("ie").value = "";
						document.getElementById("cpf").value = "";
						document.getElementById("rg").value = "";
					}
				 };
		</script>
		
		<form action="cad_cliente.php" method="post">
		  <div id="actions" class="row"> 
		
		<div class="form-group col-md-2" >
			
			<label for="">* Tipo de Pessoa</label>
			<select id="tipo_pessoa" name="tipo_pessoa" class="form-control" onchange="tipopessoa(tipo_pessoa)">
				<option value="">Selecione</option>
				<option value="F" <?php if (isset($_POST['tipo_pessoa']) && $_POST['tipo_pessoa'] == "F") echo "selected"; ?>>Pessoa Física</option>
				<option value="J" <?php if (isset($_POST['tipo_pessoa']) && $_POST['tipo_pessoa'] == "J") echo "selected"; ?>>Pessoa Juridica</option>
			</select>
		</div>		
				
			<div class="form-group col-md-3">
				<label for="nome"> * Nome</label>
				<input type="text" class="form-control" name="nome" id="nome" placeholder="" maxlength="50" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="cpf"> * CPF</label>
				<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex.: 000.000.000-00" maxlength="14" value="<?php if (isset($_POST['cpf'])) echo $_POST['cpf']; ?>" disabled>
			</div>
			
			<div class="form-group col-md-2">
				<label for="rg"> * RG</label>
				<input type="text" class="form-control" id="rg" name="rg" placeholder="" maxlength="12" value="<?php if (isset($_POST['rg'])) echo $_POST['rg']; ?>" disabled>
			</div>

			<div class="form-group col-md-2">
				<label for="cnpj"> * CNPJ</label>
				<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Ex.: 00.000.000/0000-00" maxlength="18" value="<?php if (isset($_POST['cnpj'])) echo $_POST['cnpj']; ?>" disabled>
			</div>

			<div class="form-group col-md-2">
				<label for="ie"> * IE </label>
				<input type="text" class="form-control" id="ie" name="ie" placeholder="000.000.000.000" maxlength="15" value="<?php if (isset($_POST['ie'])) echo $_POST['ie']; ?>" disabled>
			</div>

			<div class="form-group col-md-3">
				<label for="longadouro"> * Tipo de Logradouro </label>
				<input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="" maxlength="20" value="<?php if (isset($_POST['logradouro'])) echo $_POST['logradouro']; ?>">
			</div>

			<div class="form-group col-md-4">
				<label for="nome_longadouro"> * Nome do Logradouro </label>
				<input type="text" class="form-control" id="nome_logradouro" name="nome_logradouro" placeholder="" maxlength="50" value="<?php if (isset($_POST['nome_logradouro'])) echo $_POST['nome_logradouro']; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="numero"> * Número </label>
				<input type="text" class="form-control" id="num" name="num" placeholder="" maxlength="5" value="<?php if (isset($_POST['num'])) echo $_POST['num']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="complemento"> Complemento </label>
				<input type="text" class="form-control" id="complemento" name="complemento" placeholder="" maxlength="20" value="<?php if (isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="bairro"> * Bairro </label>
				<input type="text" class="form-control" id="bairro" name="bairro" placeholder="" maxlength="30" value="<?php if (isset($_POST['bairro'])) echo $_POST['bairro']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="cidade"> * Cidade  </label>
				<input type="text" class="form-control" id="cidade" name="cidade" placeholder="" maxlength="40" value="<?php if (isset($_POST['cidade'])) echo $_POST['cidade']; ?>">
			</div>

			<div class="form-group col-md-2" >
				<label for="estado">* Estado:</label>
				<select class="form-control" id="estado" name="estado">
					<option value="">Selecione</option>
					<option value="AC"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AC") echo "selected"; ?>>AC</option>
					<option value="AL"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AL") echo "selected"; ?>>AL</option>
					<option value="AP"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AP") echo "selected"; ?>>AP</option>
					<option value="AM"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AM") echo "selected"; ?>>AM</option>
					<option value="BA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "BA") echo "selected"; ?>>BA</option>
					<option value="CE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "CE") echo "selected"; ?>>CE</option>
					<option value="DF"<?php if (isset($_POST['estado']) && $_POST['estado'] == "DF") echo "selected"; ?>>DF</option>
					<option value="ES"<?php if (isset($_POST['estado']) && $_POST['estado'] == "ES") echo "selected"; ?>>ES</option>
					<option value="GO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "GO") echo "selected"; ?>>GO</option>
					<option value="MA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MA") echo "selected"; ?>>MA</option>
					<option value="MT"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MT") echo "selected"; ?>>MT</option>
					<option value="MS"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MS") echo "selected"; ?>>MS</option>
					<option value="MG"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MG") echo "selected"; ?>>MG</option>
					<option value="PA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PA") echo "selected"; ?>>PA</option>
					<option value="PB"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PB") echo "selected"; ?>>PB</option>
					<option value="PR"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PR") echo "selected"; ?>>PR</option>
					<option value="PE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PE") echo "selected"; ?>>PE</option>
					<option value="PI"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PI") echo "selected"; ?>>PI</option>
					<option value="RJ"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RJ") echo "selected"; ?>>RJ</option>
					<option value="RN"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RN") echo "selected"; ?>>RN</option>
					<option value="RS"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RS") echo "selected"; ?>>RS</option>
					<option value="RO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RO") echo "selected"; ?>>RO</option>
					<option value="RR"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RR") echo "selected"; ?>>RR</option>
					<option value="SC"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SC") echo "selected"; ?>>SC</option>
					<option value="SP"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SP") echo "selected"; ?>>SP</option>
					<option value="SE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SE") echo "selected"; ?>>SE</option>
					<option value="TO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "TO") echo "selected"; ?>>TO</option>
			</select>
			</div>


			<div class="form-group col-md-2">
				<label for="telefone"> * Telefone </label>
				<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex.: (00)0000-0000" maxlength="13" value="<?php if (isset($_POST['telefone'])) echo $_POST['telefone']; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="email"> * Celular </label>
				<input type="text" class="form-control" id="email" name="celular" placeholder="Ex.: (00)00000-0000" maxlength="14" value="<?php if (isset($_POST['celular'])) echo $_POST['celular']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="email"> * E-mail </label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Digite o seu endereço de e-mail" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="senha">* Senha</label>
				<input type="password" class="form-control" id="senha" name="senha" maxlength="10" placeholder="Digite a senha">
			</div>	

			<div class="row">
			<div class="form-group col-md-2">
				<label for="senhac">* Confirmar Senha</label>
				<input type="password" class="form-control" id="senhac" name="senhac" maxlength="10" placeholder="Confirme a senha">
			</div>
			</div>

			<hr />
			
			<div class="col-md-12">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="menu_principal.php" class="btn btn-default">Cancelar</a>
			<input type="hidden" name="enviou" value="True" />
			</div>
		</div>
	
		</form>
			<?php
		include_once('../includes/rodape.php');
		?>
</html>