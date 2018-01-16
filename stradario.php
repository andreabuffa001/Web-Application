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
		<!--tab per visualizzare tutte le zone presenti in stradario-->
		<div class="col-md-4">
			<ul class="nav nav-pills nav-stacked">
				<?php 
				$query = "SELECT REPLACE((REPLACE(zona,' ','')),'.','') NOSpazio, zona FROM DATA.VIA_T GROUP BY zona ORDER BY zona ASC";
				$result = oci_parse($con_stradario, $query);
				oci_execute($result);
				if($result){
					while($row = oci_fetch_array($result)){
						echo "<li role='presentation'><a href='#".$row["0"]."' aria-controls='profile' role='tab' data-toggle='tab'>".$row["1"]."</a></li>";
					}
				}
				?> 
  			</ul>
		</div>
		<div class="col-md-4 ">
			<!--tab per la visualizzazione delle vie presenti nelle zone-->
			<div class="tab-content">
				<?php 
				$query = "SELECT REPLACE((REPLACE(zona,' ','')),'.','') NOSpazio, zona FROM DATA.VIA_T GROUP BY zona ORDER BY zona ASC";
				$result = oci_parse($con_stradario,$query);
				oci_execute($result);
				if($result){
					while($row = oci_fetch_array($result)){
						$query2 = "SELECT idvia, CONCAT(topon,REPLACE(REPLACE(nomevia,' ',''),'''','')) topocompleto, CONCAT(CONCAT(topon,' '),nomevia) topospazio FROM DATA.VIA_T WHERE zona = '".strtoupper($row[1])."' order by topospazio asc";
						$result2 = oci_parse($con_stradario, $query2);
						oci_execute($result2);
						if($result2){
							echo "<div role='tabpanel' class='tab-pane jumbotron' id=".$row["0"].">";
							echo "<ul class='nav nav-pills nav-stacked'>";
							while($row2 = oci_fetch_array($result2)){
								echo "<li role='presentation'><a href='#".$row2["1"]."' aria-controls='profile' role='tab' data-toggle='tab'>".$row2["2"]."</a></li>";
								
								
					}
					echo "</ul>";
					echo "</div>";
				}
			}
		}
				?>
			</div>
		</div>
		<div class="col-md-4 ">
			<!--tab per visualizzare le ordinanze presenti per le singole vie-->
			<div class="tab-content">
				<?php 
				$query = "SELECT idvia, CONCAT(topon,REPLACE(REPLACE(nomevia,' ',''),'''','')) topocompleto, CONCAT(CONCAT(topon,' '),nomevia) topospazio FROM DATA.VIA_T order by topospazio asc";
				$result = oci_parse($con_stradario,$query);
				oci_execute($result);
				if($result){
					while($row = oci_fetch_array($result)){
						echo "<div role='tabpanel' class='tab-pane jumbotron' id=".$row["1"].">";
							$query2 = 'SELECT ordinanze."numero protocollo generale", ordinanze.data FROM ordinanze WHERE codvia = '.$row["0"].' ORDER BY ordinanze.data DESC';
							$result2 = pg_query($query2);
							if ($result2){
								while($row2 = pg_fetch_array($result2)){
									$newdate =  date('d-m-Y', strtotime($row2["data"]));
									echo "<a style='margin-right:10px' value='".$row2["numero protocollo generale"]."' class='btn btn-primary fancybox fancybox.iframe' href='./get_doc_ordinanza.php?num_pro=".$row2["numero protocollo generale"]."' >Ord. N&#176;".$row2["numero protocollo generale"]." del ".$newdate."</a>";
								}
							}
						echo "</div>";
					}
				}
				?> 
			</div>
		</div>
	</div>
</body>
</html>