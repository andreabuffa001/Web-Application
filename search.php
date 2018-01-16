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
		$key = $_GET['key_protocollo'];
		?>
	<title>Archivio Ordinanze</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<link rel="stylesheet" href="./fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="./fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="script.js"></script>

</head>
<body>
	<?php include("menu.php") ?>
	<div class="container-fluid">
	<!--display dei dati SELECT su db-->
	<?php
	// Recupero il numero di pagina corrente.
	// Generalmente si utilizza una querystring
	$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
	if (!$pag || !is_numeric($pag)) $pag = 1; 
	$query = 'Select DISTINCT * FROM ordinanze WHERE CAST("numero protocollo generale" as TEXT) LIKE \'%'.$key.'%\'';
	// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
	$all_rows = pg_num_rows(pg_query($query));
	$all_pages = ceil($all_rows/20);
	$first = ($pag -1)*20;
	$rs = pg_query('Select DISTINCT * FROM ordinanze WHERE CAST("numero protocollo generale" as TEXT) LIKE \'%'.$key.'%\' ORDER BY "numero protocollo generale" ASC LIMIT 21 OFFSET '.$first.'');
	$nr = pg_num_rows($rs);
	echo "Numero Protocollo ricercato:".$key." Risultati ottenuti:".$all_rows;
	if($nr != 0){?><div class='row'><?php
		for($x = 0; $x < $nr; $x++){
			$row = pg_fetch_array($rs);
			$img = "file://///srv-file/mob-pubb/ordinanze/".$row["foto"];
			$newdate =  date('d-m-Y', strtotime($row["data"]));
			echo "<div class='col-sm-6 col-md-4'><div class='thumbnail'><img src='logo.gif'><div class='caption'><h3>ORDINANZA DEL: ".$newdate." <br>N&#176;: ".$row["numero protocollo generale"]."</h3><p>(Protocollo Comune N&#176;:".$row["numero di protocollo Comune"].")</p><p><a value='".$row["numero protocollo generale"]."' class='btn btn-primary fancybox fancybox.iframe' href='./get_doc_ordinanza.php?num_pro=".$row["numero protocollo generale"]."' >Visualizza ordinanza</a></p></div></div></div>";
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