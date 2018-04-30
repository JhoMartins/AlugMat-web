<?php
//Ao tentar digitar uma url, redireciona o usuário para o index.php
//Quando não passa parâmetro ao chamar a função absolute_url, ele entende que $page é "index.php"
function absolute_url ($page = 'index.php') {
	//Identifica o servidor e diretório que o usuário está tentando acessar para poder retornar o caminho correto da página
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	//Caso o usuário digite barra incorreta, a função abaixo substitui.
	$url = rtrim($url, '/\\');
	//Adição da página correta
	$url .= '/' . $page;
	
	return $url;
}

function check_login($dbc, $nome='', $senha='') {
	$erros = array();
	
	//Validar o Nome
	if (empty($nome)) {
		$erros[] = 'Você esqueceu de digitar o seu Login.';
	}
	else {
		$n = mysqli_real_escape_string($dbc, trim($nome));
	}
	
	//Validar a Senha
	if (empty($senha)) {
		$erros[] = 'Você esqueceu de digitar a sua Senha.';
	}
	else {
		$s = mysqli_real_escape_string($dbc, trim($senha));
	}
	
	//Verificar se existem erros
	if (empty($erros)) {
		//Recuperar ID do usuário 
		//Sempre que for verificar senha, é necessário digitar a palavra "DWEBII" que foi utilizada na criptografia
		$q = "SELECT id, p_nome FROM usuario WHERE email = '$n' AND pass = SHA1('DWEBII.$s')";
		$r = mysqli_query($dbc, $q);
		
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			return array(true, $row);
		}
		else {
			$erros[] = 'O endereço de e-mail e senha digitados não coincidem com aqueles armazenados.';
		}
	}
	return array(false, $erros);
}
?>