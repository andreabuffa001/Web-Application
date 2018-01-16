<?php

error_reporting(E_ALL);

$_CONFIG['host'] = "127.0.0.1";
$_CONFIG['user'] = "test";
$_CONFIG['pass'] = "test";
$_CONFIG['dbname'] = "ordinanze";

$_CONFIG['table_sessioni'] = "sessioni";
$_CONFIG['table_utenti'] = "utenti";

$_CONFIG['expire'] = 3600;
$_CONFIG['regexpire'] = 24; //in ore

$_CONFIG['check_table'] = array(
	"username" => "check_username",
	"password" => "check_global",
	"name" => "check_global",
	"surname" => "check_global",
	"indirizzo" => "check_global",
	"occupazione" => "check_global",
	"mail" => "check_global"
);

function check_username($value){
	global $_CONFIG;
	
	$value = trim($value);
	if($value == "")
		return "Il campo non pu� essere lasciato vuoto";
	$query = pg_query("
	SELECT id
	FROM ".$_CONFIG['table_utenti']."
	WHERE username='".$value."'");
	if(pg_num_rows($query) != 0){
		return "Nome utente gi� utilizzato";
	}
	return true;
}

function check_global($value){
	global $_CONFIG;
	
	$value = trim($value);
	if($value == "")
		return "Il campo non pu� essere lasciato vuoto";
	
	return true;
}


//--------------
define('AUTH_LOGGED', 99);
define('AUTH_NOT_LOGGED', 100);

define('AUTH_USE_COOKIE', 101);
define('AUTH_USE_LINK', 103);
define('AUTH_INVALID_PARAMS', 104);
define('AUTH_LOGEDD_IN', 105);
define('AUTH_FAILED', 106);

define('REG_ERRORS', 107);
define('REG_SUCCESS', 108);
define('REG_FAILED', 109);

$conn = pg_connect("host=".$_CONFIG['host']." dbname=".$_CONFIG['dbname']." user=".$_CONFIG['user']." password=".$_CONFIG['pass']."") or die('Impossibile stabilire una connessione');
?>
