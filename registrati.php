<html>
<head>
	<?php
		include("link.php");
		include("conn.php"); 
		?>
<title>Modulo di registrazione</title>
</head>
<body>
<div class="container-fluid col-md-6">
	<div class="jumbotron">
		<img src="Logo_cremona.jpg" alt="comune di cremona" class="img-rounded" width="100%">
		<h3>Form di registrazione</h3>
		<form action="register.php" method="post">
			<div align="center">
				<table border="0" width="300">
					<tr>
						<td>Nome:</td>
						<td><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>Cognome:</td>
						<td><input type="text" name="surname"></td>
					</tr>
					<tr>
						<td>Indirizzo:</td>
						<td><input type="text" name="indirizzo"></td>
					</tr>
					<tr>
						<td>Occupazione</td>
						<td><input type="text" name="occupazione"></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username"></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr>
						<td>Mail:</td>
						<td><input type="text" name="mail"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="action" value="Invia"></td>
					</tr>
				</table>
			</div>
		</form>
		<a href="archive.php">Ritorna all'archivio</a> Oppure <a href="login.php">Accedi</a>
	</div>
</div>
</body>
</html>