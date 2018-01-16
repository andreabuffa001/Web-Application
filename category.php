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
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<link rel="stylesheet" href="./fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="./fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<!--Menu-->
	<?php include("menu.php") ?>
	<!--Menu-->
	<div class="container-fluid">
		<ul class="nav nav-tabs">
  			<li role="presentation" class="active"><a href="#carico_scarico" aria-controls="profile" role="tab" data-toggle="tab">Carico/Scarico</a></li>
  			<li role="presentation"><a href="#cs2" aria-controls="profile" role="tab" data-toggle="tab">CS2</a></li>
	  		<li role="presentation"><a href="#disabili_giunta-P" aria-controls="profile" role="tab" data-toggle="tab">Disabili Giunta P</a></li>
			<li role="presentation"><a href="#disabili_giunta-c" aria-controls="profile" role="tab" data-toggle="tab">Disabili Giunta C</a></li>
			<li role="presentation"><a href="#divieto_autocarri_2000" aria-controls="profile" role="tab" data-toggle="tab">Divieto autocarri 200</a></li>
			<li role="presentation"><a href="#dossi" aria-controls="profile" role="tab" data-toggle="tab">Dossi</a></li>
			<li role="presentation"><a href="#bus_extraurbani" aria-controls="profile" role="tab" data-toggle="tab">Bus Estraurbani</a></li>
			<li role="presentation"><a href="#farmacia" aria-controls="profile" role="tab" data-toggle="tab">Farmacia</a></li>
			<li role="presentation"><a href="#piste_ciclabili" aria-controls="profile" role="tab" data-toggle="tab">Piste Ciclabili</a></li>
			<li role="presentation"><a href="#sensi_unici" aria-controls="profile" role="tab" data-toggle="tab">Sensi Unici</a></li>
		</ul>
		<!--tab da visualizzare-->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane" id="disabili_giunta-c">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM "disabili giunta c" ORDER BY "numero protocollo generale" ASC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "disabili giunta c" inner join ordinanze on "disabili giunta c"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Disabili Giunta C</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="divieto_autocarri_2000">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM divieto_autocarri_2000 ORDER BY "numero protocollo generale" ASC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM divieto_autocarri_2000 inner join ordinanze on divieto_autocarri_2000."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Divieti autocarri 2000</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="bus_extraurbani">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM "bus extraurbani" ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "bus extraurbani" inner join ordinanze on "bus extraurbani"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Bus Extraurbani</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane active" id="carico_scarico">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select DISTINCT * FROM "carico scarico" ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "carico scarico" inner join ordinanze on "carico scarico"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Carico/Scarico</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="cs2">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM cs2 ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM cs2 inner join ordinanze on cs2."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>CS2</b>' risultati ottenuti:".$all_rows.". Pagina".$pag."/".$all_pages;
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
			<div role="tabpanel" class="tab-pane" id="disabili_giunta-P">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM "disabili giunta p" ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "disabili giunta p" inner join ordinanze on "disabili giunta p"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Disabili Giunta P.</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="dossi">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM dossi ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM dossi inner join ordinanze on dossi."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Dossi</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="farmacia">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM "farmacia 11" ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "farmacia 11" inner join ordinanze on "farmacia 11"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Farmacia</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="piste_ciclabili">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM "piste_cicl" ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM "piste_cicl" inner join ordinanze on "piste_cicl"."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Piste Ciclabili</b>' risultati ottenuti:".$all_rows;
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
			<div role="tabpanel" class="tab-pane" id="sensi_unici">
				<!--display dei dati SELECT su db-->
				<?php
					// Recupero il numero di pagina corrente.
					// Generalmente si utilizza una querystring
					$pag = isset($_GET['pag']) ? $_GET['pag'] : 1; 
						if (!$pag || !is_numeric($pag)) $pag = 1; 
							$query = 'Select * FROM sensi ORDER BY "numero protocollo generale" DESC';
							// Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
							$result = pg_query($query);
							$all_rows = pg_num_rows(pg_query($query));
							$all_pages = ceil($all_rows/21);
							$first = ($pag -1)*21;
							$rs = pg_query('SELECT * FROM sensi inner join ordinanze on sensi."numero protocollo generale"= ordinanze."numero protocollo generale" ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 21');
							$nr = pg_num_rows($rs);
							echo "Per la categoria '<b>Sensi Unici</b>' risultati ottenuti:".$all_rows;
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
		</div>
	</div>
</body>
</html>