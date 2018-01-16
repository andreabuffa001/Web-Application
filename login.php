<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK){
	$link = "?uid=".$_GET['uid'];
}else	$link = '';
?>
<html>
	<head>
		<?php
		include("link.php");
		include("conn.php"); 
		?>
	</head>
	<body>
	<div align="center">
		<?php
		switch($status){
			case AUTH_LOGGED:
			?>
		<b>Sei loggato con il nome di <?=$user["name"];?> <a href="logout.php<?=$link?>">Logout</a></b>
			<?php
			break;
			case AUTH_NOT_LOGGED:
			?>
<div class="container-fluid col-md-8" align="center">
	<div class="jumbotron" align="center">
		<img src="Logo_cremona.jpg" alt="comune di cremona" class="img-rounded" width="100%">
			<h3>Accedi</h3>
				<form action="connect-login.php<?=$link?>" method="post">
					<table cellspacing="2">
						<tr>
							<td>Nome Utente:</td>
							<td><input type="text" name="uname" class="form-control"></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="passw" class="form-control"></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="action" value="login" class="btn btn-default"></td>
							<td><a class="btn btn-default" href="registrati.php">Registrati</td>
						</tr>
					</table>
				</form>
		<?php
			break;                 
		}
		?>
	</div>
</div>
	</div>
	</body>
</html>