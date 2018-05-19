<?php
	$codigo = $_GET['codigo'];
	$nome = $_GET['nome'];
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
	<tr>
		<td><?= $nome; ?></td>
	</tr>
	<tr>
		<td valign="top"><img src="imagens/<?= $codigo; ?>G.jpg" /></td>
	</tr>
</table>