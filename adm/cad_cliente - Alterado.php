<?php
	$titulo = "Cadastro de Usuário";
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
		
		//CPF_CNPJ
		if (empty($_POST['cpf_cnpj'])) {
			$erros[] = 'Por favor, informe o CPF/CNPJ.';
		}
		else {
			$cpf_cnpj = (!empty($_POST['cpf_cnpj'])) ? mysqli_real_escape_string($dbc,trim($_POST['cpf_cnpj'])) : NULL;
			
			if (strlen($cpf_cnpj) > 14) {
				$cpf = null;
				$cnpj = $cpf_cnpj;
			}
			else {
				$cpf = $cpf_cnpj;
				$cnpj = null;
			}
		}
		
		//RG_IE
		if ($_POST['tipo_pessoa'] == 'F' && empty($_POST['rg_ie'])) {
			$erros[] = 'Por favor, informe o RG.';
		}
		else {
			$rg_ie = (!empty($_POST['rg_ie'])) ? mysqli_real_escape_string($dbc,trim($_POST['rg_ie'])) : NULL;
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
			$complemento = mysqli_real_escape_string($dbc,trim($_POST['complemento']));
		}
		else {
			$complemento = "";
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
		
		//STATUS
		if (empty($_POST['status'])) {
			$erros[] = 'Por favor, informe o Status.';
		}
		else {
			$status = mysqli_real_escape_string($dbc,trim($_POST['status']));
		}
		
		//TIPO USUÁRIO
		if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM' && empty($_POST['tipo_usuario'])) {
			$erros[] = 'Por favor, informe o Tipo de Usuário';
		}
		else if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM' && !empty($_POST['tipo_usuario'])) {
			$tipo_usuario = $_POST['tipo_usuario'];
		}
		else {
			$tipo_usuario = 'USU';
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
										tipo_usuario,
										status
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
										'".SHA1('bd_alugmat'.$senha)."',
										NOW(),
										'$tipo_usuario',
										'$status')";
										//die("<pre>".$qry."</pre>");
			$res = @mysqli_query($dbc,$qry);
			
			if ($res) {
				$sucesso = "<h1><strong>Sucesso!</strong></h1>
							<p>Seu registro foi incluido com sucesso!</p>
							<p>Aguarde... Redirecionando!</p>";
				
				if ((isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'USU') || !isset($_SESSION['tipo_usuario'])) {
					echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=../index.php'>";
				}
				else if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') {
					echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=menu_cliente.php'>";
				}
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
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
   <script src="../js/masks.js"></script>


	<div id="main" class="container-fluid">
		<h3 class="page-header">Cadastro de Usuário</h3>
		
		<script>
		function tipopessoa(e) { 
					if(e.value == "F") {
						document.getElementById("cpf_cnpj").disabled = false;
						document.getElementById("rg_ie").disabled = false;
						document.getElementById("cpf_cnpj").value = "";
						document.getElementById("rg_ie").value = "";
					} if(e.value == "J") {
						document.getElementById("cpf_cnpj").disabled = false;
						document.getElementById("rg_ie").disabled = false;
						document.getElementById("cpf_cnpj").value = "";
						document.getElementById("rg_ie").value = "";
					}
					if (e.value == "") {
						document.getElementById("cpf_cnpj").disabled = true;
						document.getElementById("rg_ie").disabled = true;
						document.getElementById("cpf_cnpj").value = "";
						document.getElementById("rg_ie").value = "";
					}
				 };
		</script>
		
		<form action="cad_cliente.php" method="post">
		  <div id="actions" class="row"> 
		
		<div class="form-group col-md-3" >
			
			<label for="">* Tipo de Pessoa</label>
			<select id="tipo_pessoa" name="tipo_pessoa" class="form-control" onchange="tipopessoa(tipo_pessoa)">
				<option value="">Selecione</option>
				<option value="F" <?php if (isset($_POST['tipo_pessoa']) && $_POST['tipo_pessoa'] == "F") echo "selected"; ?>>Pessoa Física</option>
				<option value="J" <?php if (isset($_POST['tipo_pessoa']) && $_POST['tipo_pessoa'] == "J") echo "selected"; ?>>Pessoa Juridica</option>
			</select>
		</div>		
				
			<div class="form-group col-md-9">
				<label for="nome"> * Nome</label>
				<input type="text" class="form-control" name="nome" id="nome" placeholder="" maxlength="50" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="cpf"> * CPF/CNPJ</label>
				<input type="text" class="form-control cpf" id="cpf_cnpj" name="cpf_cnpj" placeholder="Selecione o Tipo de Pessoa" value="<?php if (isset($_POST['cpf_cnpj'])) echo $_POST['cpf_cnpj']; if (isset($_POST['cpf_cnpj'])) echo $_POST['cpf_cnpj']; ?>" disabled>
			</div>
			
			<div class="form-group col-md-3">
				<label for="rg"> * RG/IE</label>
				<input type="text" class="form-control" id="rg_ie" name="rg_ie" placeholder="Selecione o Tipo de Pessoa" value="<?php if (isset($_POST['rg_ie'])) echo $_POST['rg_ie']; if (isset($_POST['rg_ie'])) echo $_POST['rg_ie']; ?>" disabled>
			</div>
			
			<div class="form-group col-md-3">
				<label for="telefone"> * Telefone </label>
				<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex.: (00) 0000-0000" maxlength="14" value="<?php if (isset($_POST['telefone'])) echo $_POST['telefone']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="email"> * Celular </label>
				<input type="text" class="form-control" id="celular" name="celular" placeholder="Ex.: (00) 00000-0000" maxlength="15" value="<?php if (isset($_POST['celular'])) echo $_POST['celular']; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="longadouro"> * Tipo de Logradouro </label>
				<input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="" maxlength="20" value="<?php if (isset($_POST['logradouro'])) echo $_POST['logradouro']; ?>">
			</div>

			<div class="form-group col-md-6">
				<label for="nome_longadouro"> * Nome do Logradouro </label>
				<input type="text" class="form-control" id="nome_logradouro" name="nome_logradouro" placeholder="" maxlength="50" value="<?php if (isset($_POST['nome_logradouro'])) echo $_POST['nome_logradouro']; ?>">
			</div>

			<div class="form-group col-md-1">
				<label for="numero"> * Núm. </label>
				<input type="text" class="form-control" id="num" name="num" placeholder="" maxlength="5" value="<?php if (isset($_POST['num'])) echo $_POST['num']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="complemento"> Complemento </label>
				<input type="text" class="form-control" id="complemento" name="complemento" placeholder="" maxlength="20" value="<?php if (isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
			</div>

			<div class="form-group col-md-4">
				<label for="bairro"> * Bairro </label>
				<input type="text" class="form-control" id="bairro" name="bairro" placeholder="" maxlength="30" value="<?php if (isset($_POST['bairro'])) echo $_POST['bairro']; ?>">
			</div>

			<div class="form-group col-md-5">
				<label for="cidade"> * Cidade  </label>
				<input type="text" class="form-control" id="cidade" name="cidade" placeholder="" maxlength="40" value="<?php if (isset($_POST['cidade'])) echo $_POST['cidade']; ?>">
			</div>

			<div class="form-group col-md-3" >
				<label for="estado">* Estado:</label>
				<select class="form-control" id="estado" name="estado">
					<option value="">Selecione</option>
					<option value="AC"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AC") echo "selected"; ?>>Acre</option>
					<option value="AL"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AL") echo "selected"; ?>>Alagoas</option>
					<option value="AP"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AP") echo "selected"; ?>>Amapá</option>
					<option value="AM"<?php if (isset($_POST['estado']) && $_POST['estado'] == "AM") echo "selected"; ?>>Amazonas</option>
					<option value="BA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "BA") echo "selected"; ?>>Bahia</option>
					<option value="CE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "CE") echo "selected"; ?>>Ceará</option>
					<option value="DF"<?php if (isset($_POST['estado']) && $_POST['estado'] == "DF") echo "selected"; ?>>Distrito Federal</option>
					<option value="ES"<?php if (isset($_POST['estado']) && $_POST['estado'] == "ES") echo "selected"; ?>>Espírito Santo</option>
					<option value="GO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "GO") echo "selected"; ?>>Goiás</option>
					<option value="MA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MA") echo "selected"; ?>>Maranhão</option>
					<option value="MT"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MT") echo "selected"; ?>>Mato Grosso</option>
					<option value="MS"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MS") echo "selected"; ?>>Mato Grosso do Sul</option>
					<option value="MG"<?php if (isset($_POST['estado']) && $_POST['estado'] == "MG") echo "selected"; ?>>Minas Gerais</option>
					<option value="PA"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PA") echo "selected"; ?>>Pará</option>
					<option value="PB"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PB") echo "selected"; ?>>Paraíba</option>
					<option value="PR"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PR") echo "selected"; ?>>Paraná</option>
					<option value="PE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PE") echo "selected"; ?>>Pernambuco</option>
					<option value="PI"<?php if (isset($_POST['estado']) && $_POST['estado'] == "PI") echo "selected"; ?>>Piauí</option>
					<option value="RJ"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RJ") echo "selected"; ?>>Rio de Janeiro</option>
					<option value="RN"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RN") echo "selected"; ?>>Rio Grande do Norte</option>
					<option value="RS"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RS") echo "selected"; ?>>Rio Grande do Sul</option>
					<option value="RO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RO") echo "selected"; ?>>Rondônia</option>
					<option value="RR"<?php if (isset($_POST['estado']) && $_POST['estado'] == "RR") echo "selected"; ?>>Roraima</option>
					<option value="SC"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SC") echo "selected"; ?>>Santa Catarina</option>
					<option value="SP"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SP") echo "selected"; ?>>São Paulo</option>
					<option value="SE"<?php if (isset($_POST['estado']) && $_POST['estado'] == "SE") echo "selected"; ?>>Sergipe</option>
					<option value="TO"<?php if (isset($_POST['estado']) && $_POST['estado'] == "TO") echo "selected"; ?>>Tocantins</option>
			</select>
			</div>
			
			<div class="form-group col-md-4">
				<label for="email"> * E-mail </label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Digite o seu endereço de e-mail" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="senha">* Senha</label>
				<input type="password" class="form-control" id="senha" name="senha" maxlength="10" placeholder="Digite a senha">
			</div>	

			
			<div class="form-group col-md-3">
				<label for="senhac">* Confirmar Senha</label>
				<input type="password" class="form-control" id="senhac" name="senhac" maxlength="10" placeholder="Confirme a senha">
			</div>
			
			
			<div class="form-group col-md-2" >
				<label for="estado">* Status:</label>
				<select class="form-control" id="status" name="status">
					<option value="">Selecione</option>
					<option value="S"<?php if (isset($_POST['status']) && $_POST['status'] == "S") echo "selected"; ?>>Ativo</option>
					<option value="N"<?php if (isset($_POST['status']) && $_POST['status'] == "N") echo "selected"; ?>>Inativo</option>
			</select>
			</div>
			
			<?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') { ?>
				<div class="form-group col-md-2">
						<label for="tipo_usuario">* Tipo de Usuário:</label>
							<select class="form-control" id="tipo_usuario" name="tipo_usuario">
								<option value="">Selecione</option>
								<option value="ADM" <?php if (isset($_POST['tipo_usuario']) && $_POST['tipo_usuario'] == 'ADM') { echo "selected"; } ?>>Administrador</option>
								<option value="USU" <?php if (isset($_POST['tipo_usuario']) && $_POST['tipo_usuario'] == 'USU') { echo "selected"; } ?>>Usuário</option>
							</select>
				</div>
			<?php } ?>
			
			
			<div class="row">
			</div>

			<hr />
			
			<div class="col-md-12">
			<button type="submit" class="btn btn-primary">Salvar</button>
			<?php
			if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') {
				echo '<a href="menu_cliente.php" class="btn btn-default">Cancelar</a>';
			}
			else if ((isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'USU') || !isset($_SESSION['tipo_usuario'])) {
				echo '<a href="../index.php" class="btn btn-default">Cancelar</a>';
			}
			?>
			<input type="hidden" name="enviou" value="True" />
			</div>
		</div>
	
		</form>
			<?php
		include_once('../includes/rodape.php');
		?>
</html>