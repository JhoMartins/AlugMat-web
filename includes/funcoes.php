<?php
  function absolute_url ($page = 'index.php') {
	  $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	  $url = rtrim($url, '/\\');
	  $url .= '/' . $page;
	  return $url;
  }

  function check_login($dbc, $nome = '', $senha = ''){
	  $erros = array();

	  if (empty($nome)) {
		  $erros[] = 'Você esqueceu de digitar o seu Login.<br /><br />Por favor, tente novamente.';
	  }
	  else {
		$n = mysqli_real_escape_string($dbc, trim($nome));
	  }

	  if (empty($senha)) {
	    $erros[] = 'Você esqueceu de digitar a sua Senha.<br /><br />Por favor, tente novamente.';
	  }
	  else {
	    $s = mysqli_real_escape_string($dbc, trim($senha));
	  }
	  

	  if (empty($erros)){
		$q = "SELECT id, nome, tipo_usuario, status FROM cliente WHERE email = '$n' AND senha = '" . SHA1('bd_alugmat'.$s) . "'";
		//die($q);
		$r = mysqli_query($dbc, $q);
		$reg = mysqli_fetch_array($r);
		
		if (mysqli_num_rows($r) == 1) {
			if (isset($reg['status']) && $reg['status'] == 'S') {
				return array(true, $reg);
			}
			else {
				$erros[] = 'Usuário bloqueado! Por favor, entre em contato com o suporte da Alugmat.<br /><br />Telefone para contato: 0800 777 2234';
			}
		}
		else {
			$erros[] = 'E-mail ou senha iválido.<br /><br />Por favor, tente novamente.';
		}
	  }
	return array(false, $erros);
  }
?>