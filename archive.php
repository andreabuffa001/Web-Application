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
	<!--Menu-->
	<?php include("menu.php") ?>
	<!--Menu-->
	<div class="container-fluid">
	<!--display dei dati SELECT su db-->
	<?php
	// Recupero il numero di pagina corrente.
	// Generalmente si utilizza una querystring
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
	if (!$pag || !is_numeric($pag)) $pag = 1; 
	$query = 'Select * FROM ordinanze ORDER BY ordinanze."numero protocollo generale" DESC';
	// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
	$result = pg_query($query);
	$all_rows = pg_num_rows(pg_query($query));
	$all_pages = ceil($all_rows/20);
	$first = ($pag -1)*20;
	$rs = pg_query('Select * FROM ordinanze ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 102 OFFSET '.$first.'');
	$nr = pg_num_rows($rs);
	if($nr != 0){?><div class='row'><?php
		for($x = 0; $x < $nr; $x++){
			$row = pg_fetch_array($rs);
			$img = "file://///srv-file/mob-pubb/ordinanze/".$row["foto"];
			$newdate =  date('d-m-Y', strtotime($row["data"]));
			echo "<div class='col-sm-6 col-md-4'>"
                        . "<div class='thumbnail'>"
                                . "<img src='logo.gif'>"
                                . "<div class='caption'>"
                                . "<h3>ORDINANZA DEL: ".$newdate." <br>N&#176;: ".$row["numero protocollo generale"]."</h3>"
                                . "<p>(Protocollo Comune N&#176;:".$row["numero di protocollo Comune"].")</p>"
                                . "<p>"
                                . "<a value='".$row["numero protocollo generale"]."' class='btn btn-primary fancybox fancybox.iframe' href='./get_doc_ordinanza.php?num_pro=".$row["numero protocollo generale"]."' >Visualizza ordinanza</a>"
                                . "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>";
		}
		?></div><?php
		
}else{
  echo "Nessun record trovato!";
}
include("pagination.php");
?>
</div>
</body>
</html>