<?php 
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		include("link.php");
		include("conn.php"); 
		?>
	<title>Archivio Ordinanze</title>
</head>
<body>
	<div class="container-fluid col-md-6">
		<img src="Logo_cremona.jpg" alt="comune di cremona" class="img-rounded" width="100%">
		<a style="margin-top: 40px;" type="button" class="btn btn-primary btn-lg btn-block" href="./login.php">Accedi per Amministrazione</a>
		<a type="button" class="btn btn-default btn-lg btn-block" href="./archive.php">Visualizza Archivio</a>
	</div>
	</body>
</html>