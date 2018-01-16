<?php
echo "Stampa dei file presenti in cartella MOb-PUBB";
$dir=scandir("\\\\srv-file\mob-pubb\STRADARIO\fotoSUSC");
   print_r($dir);

include("link.php");
include("conn.php");

$data = array();
$query = "SELECT cod, CONCAT(topon,REPLACE(REPLACE(nomevia,' ',''),'\'','')) AS topocompleto , CONCAT (topon,' ',nomevia) as topospazio FROM `stradario` order by topospazio asc";
$result = mysql_query($query);
$data = array ();
if($result){
	while($row2 = mysql_fetch_array($result)){
		$data[]=$row2["cod"];

	}
}

//format the data
$formattedData = json_encode($data);

//set the filename
$filename = 'vie_solocodvia.json';

//open or create the file
$handle = fopen($filename,'w+');

//write the data into the file
fwrite($handle,$formattedData);

//close the file
fclose($handle);
?>