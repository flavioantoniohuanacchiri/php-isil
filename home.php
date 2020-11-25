<?php 
	include __DIR__."/functions/session_helper.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include __DIR__."/resources/views/includes/head.phtml";
		?>
		<title>Home</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<h1>Bienvenido <?php echo $_SESSION["user"]["nombre"];?></h1>
			<p>Aquí podrás realizar mantenimientos a Productos, Categorías, Usuarios, Perfiles y Empleados</p>
		</div>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
		?>
	</body>
</html>
