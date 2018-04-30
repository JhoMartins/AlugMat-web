<?php
	function absolute_url ($page = 'menu_principal.php')
	{
		$url = 'http://' . $_SERVER['HTTP_HOST'] .
		dirname($_SERVER['PHP_SELF']);
		$url = rtrim($url, '/\\');
		$url.='/'.$page;
		return $url;
	}

	function check_login($dbc, $nome='', $senha='')
	{
		$erros = array();
		if (empty($nome)) {
			$erros[] = 'Você esqueceu de digitar o seu login.';
		} else {
			$n = mysqli_real_escape_string($dbc, trim($nome));
		}

		if (empty($senha)) {
			$erros[] = 'Você esqueceu de digitar a sua senha.';
		} else {
			$s = mysqli_real_escape_string($dbc, trim($senha));
		}

		if (empty($erros)) {
			//sem erros
			//recuperar ID do usuario

			$q = "SELECT id, p_nome FROM usuario WHERE email = '$n' AND pass = SHA1('M@c@c8!ouc832.$s')";
			$r = mysqli_query($dbc, $q);

			if (mysqli_num_rows($r) == 0)
			{
				$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

				return array(true, $row);
			} 
			else
			{
				$erros = 'Informações não coincidem!';
			}
		}
		return array(false, $erros);
	}
?> 