<ul class="nav nav-sidebar">
<?php
	//die($_SESSION['tipo_usuario']);
	if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'ADM') {
		echo
		'<li><a href="#"><span class="glyphicon glyphicon-send"></span> Link</a></li>
		<li class="#"><a href="#"><span class="glyphicon glyphicon-plane"></span> Active Link</a></li>
		<li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li>';
	}
?>
</ul>