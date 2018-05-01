<?php
	//include_once('../includes/cabecalho.php');
	
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

		$qry = "delete from cliente where id = $id";
		$res = @mysqli_query($dbc,$qry);
		
		if ($res) {
			$sucesso = "<h1><strong>Sucesso!</strong></h1>
						<p>Seu registro foi incluido com sucesso!</p>
						<p>Aguarde... Redirecionando!</p>";
			
			//echo "<meta HTTP-EQUIV='refresh' CONTENT='3; URL=usuario_menu.php'>";
		}
		else {
			$erro = "<h1><strong>Erro no Sistema</strong></h1>
					 <p>Você não pode ser registrado devido a um erro do sistema. Pedimos desculpas por qualquer inconveniente.</p>";
			
			$erro .= '<p>' . mysqli_error($dbc) . '<br /> Query: ' . $q . '</p>';
		}
	}
	
	//Pesquisa para exibir o registro para alteração
	$qry = "select * from cliente where id = $id";
	$res = @mysqli_query($dbc, $qry);
  
	if (mysqli_num_rows($res) == 1) {
		$row = mysqli_fetch_array($res, MYSQLI_NUM);

?>

<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Alugmat</title>

<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Exclusão de Usuário</a>
			</div>
			<div id="navbar" class="navbar-collapsed collapsed">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../menu_principal.html">Início</a></li>
				<li><a href="#">Contato</a></li>
				<li><a href="#">Outros</a></li>
			</ul>
			</div>
		</div>
	</nav>
	<div id="main" class="container-fluid">
		<h3 class="page-header">Alteração de Usuário</h3>
		
		<form action="exc_cliente.php" method="post">
		  <div id="actions" class="row"> 
			<div class="form-group col-md-2" >
				<label for="">Tipo de Pessoa</label>
				<select name="tipo_pessoa" class="form-control">
					<option value="">Selecione</option>
					<option value="F" <?php if ($row[1] == "F") echo "selected"; ?>>Pessoa Física</option>
					<option value="J" <?php if ($row[1] == "J") echo "selected"; ?>>Pessoa Juridica</option>
				</select>
			</div>		
					
			<div class="form-group col-md-3">
				<label for="nome"> * Nome</label>
				<input type="text" class="form-control" name="nome" id="nome" placeholder="" maxlength="50" value="<?php echo $row[2]; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="cpf"> * CPF</label>
				<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex.: 000.000.000-00" maxlength="14" value="<?php echo $row[3]; ?>" <?php //if (tipo_pessoa != "F") echo "disabled"; ?>>
			</div>
			
			<div class="form-group col-md-2">
				<label for="rg"> * RG</label>
				<input type="text" class="form-control" id="rg" name="rg" placeholder="" maxlength="12" value="<?php echo $row[4]; ?>" <?php //if (tipo_pessoa != "F") echo "disabled"; ?>>
			</div>

			<div class="form-group col-md-2">
				<label for="cnpj"> * CNPJ</label>
				<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Ex.: 00.000.000/0000-00" maxlength="18" value="<?php echo $row[5]; ?>" <?php //if (tipo_pessoa != "J") echo "disabled"; ?>>
			</div>

			<div class="form-group col-md-2">
				<label for="ie"> * IE </label>
				<input type="text" class="form-control" id="ie" name="ie" placeholder="000.000.000.000" maxlength="15" value="<?php echo $row[6]; ?>" <?php //if (tipo_pessoa != "J") echo "disabled"; ?>>
			</div>

			<div class="form-group col-md-2">
				<label for="longadouro"> * Tipo de Logradouro </label>
				<input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="" maxlength="20" value="<?php echo $row[7]; ?>">
			</div>

			<div class="form-group col-md-6">
				<label for="nome_longadouro"> * Nome do Logradouro </label>
				<input type="text" class="form-control" id="nome_logradouro" name="nome_logradouro" placeholder="" maxlength="50" value="<?php echo $row[8]; ?>">
			</div>

			<div class="form-group col-md-1">
				<label for="numero"> * Número </label>
				<input type="text" class="form-control" id="num" name="num" placeholder="" maxlength="5" value="<?php echo $row[9]; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="complemento"> Complemento </label>
				<input type="text" class="form-control" id="complemento" name="complemento" placeholder="" maxlength="20" value="<?php echo $row[10]; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="bairro"> * Bairro </label>
				<input type="text" class="form-control" id="bairro" name="bairro" placeholder="" maxlength="30" value="<?php echo $row[11]; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="cidade"> * Cidade  </label>
				<input type="text" class="form-control" id="cidade" name="cidade" placeholder="" maxlength="40" value="<?php echo $row[12]; ?>">
			</div>

			<div class="form-group col-md-2" >
				<label for="estado">* Estado:</label>
				<select class="form-control" id="estado" name="estado">
					<option value="">Selecione</option>
					<option value="AC" <?php if ($row[13] == "AC") echo "selected"; ?>>AC</option>
					<option value="AL" <?php if ($row[13] == "AL") echo "selected"; ?>>AL</option>
					<option value="AP" <?php if ($row[13] == "AP") echo "selected"; ?>>AP</option>
					<option value="AM" <?php if ($row[13] == "AM") echo "selected"; ?>>AM</option>
					<option value="BA" <?php if ($row[13] == "BA") echo "selected"; ?>>BA</option>
					<option value="CE" <?php if ($row[13] == "CE") echo "selected"; ?>>CE</option>
					<option value="DF" <?php if ($row[13] == "DF") echo "selected"; ?>>DF</option>
					<option value="ES" <?php if ($row[13] == "ES") echo "selected"; ?>>ES</option>
					<option value="GO" <?php if ($row[13] == "GO") echo "selected"; ?>>GO</option>
					<option value="MA" <?php if ($row[13] == "MA") echo "selected"; ?>>MA</option>
					<option value="MT" <?php if ($row[13] == "MT") echo "selected"; ?>>MT</option>
					<option value="MS" <?php if ($row[13] == "MS") echo "selected"; ?>>MS</option>
					<option value="MG" <?php if ($row[13] == "MG") echo "selected"; ?>>MG</option>
					<option value="PA" <?php if ($row[13] == "PA") echo "selected"; ?>>PA</option>
					<option value="PB" <?php if ($row[13] == "PB") echo "selected"; ?>>PB</option>
					<option value="PR" <?php if ($row[13] == "PR") echo "selected"; ?>>PR</option>
					<option value="PE" <?php if ($row[13] == "PE") echo "selected"; ?>>PE</option>
					<option value="PI" <?php if ($row[13] == "PI") echo "selected"; ?>>PI</option>
					<option value="RJ" <?php if ($row[13] == "RJ") echo "selected"; ?>>RJ</option>
					<option value="RN" <?php if ($row[13] == "RN") echo "selected"; ?>>RN</option>
					<option value="RS" <?php if ($row[13] == "RS") echo "selected"; ?>>RS</option>
					<option value="RO" <?php if ($row[13] == "RO") echo "selected"; ?>>RO</option>
					<option value="RR" <?php if ($row[13] == "RR") echo "selected"; ?>>RR</option>
					<option value="SC" <?php if ($row[13] == "SC") echo "selected"; ?>>SC</option>
					<option value="SP" <?php if ($row[13] == "SP") echo "selected"; ?>>SP</option>
					<option value="SE" <?php if ($row[13] == "SE") echo "selected"; ?>>SE</option>
					<option value="TO" <?php if ($row[13] == "TO") echo "selected"; ?>>TO</option>
			</select>
			</div>


			<div class="form-group col-md-2">
				<label for="telefone"> * Telefone </label>
				<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex.: (00)0000-0000" maxlength="13" value="<?php echo $row[14]; ?>">
			</div>

			<div class="form-group col-md-2">
				<label for="email"> * Celular </label>
				<input type="text" class="form-control" id="email" name="celular" placeholder="Ex.: (00)00000-0000" maxlength="14" value="<?php echo $row[15]; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="email"> * E-mail </label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Digite o seu endereço de e-mail" maxlength="80" value="<?php echo $row[16]; ?>">
			</div>

			
			<div class="row">

			</div>
			
			<hr />
			
			<div class="col-md-12">
			<button type="submit" class="btn btn-danger">Excluir</button>
			<a href="index.html" class="btn btn-default">Cancelar</a>
			<input type="hidden" name="enviou" value="True" />
			<input type="hidden" name="id" value="<?php echo $row[0]; ?>" />
			</div>
		  </div>
		 <?php
		include_once('../includes/rodape.php');
		?>
		  
		</form>
		
<?php
  }
  
  mysqli_close($dbc);
  
  include_once('../includes/rodape.php');
?>		