<html>
<head>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<?php
include_once("include/config.php");
include_once("include/reg.lib.php");

if(isset($_POST['action']) and $_POST['action'] == 'Invia'){
	$ret = reg_check_data($_POST);
	$status = ($ret === true) ? reg_register($_POST) : REG_ERRORS;
	
	switch($status){
		case REG_ERRORS:
			?>
			<span class="style1">Sono stati rilevati i seguenti errori:</span><br>
			<?php
			foreach($ret as $error)
				printf("<b>%s</b>: %s<br>", $error[0], $error[1]);
			?>
			<br>Premere "indietro" per modificare i dati
			<?php
		break;
		case REG_FAILED:
			echo "Registrazione Fallita a causa di un errore interno.";
		break;
		case REG_SUCCESS:
			echo "Registrazione avvenuta con successo.<br>
			<a href='login.php'>Accedi all'archivio</a>.";
		break;
	}
}
?>
</body>
</html>