<?php 
$con = pg_connect("host=10.4.10.170 dbname=ordinanze user=ordinanze password=ordinanze") or die("<html><script language='JavaScript'>alert('Collegamento alle ordinanze non riuscito. Riprova più tardi.'),history.go(-1)</script></html>");
$con_stradario = oci_connect('intranet','intranet','sitp.cr.comune') or die("<html><script language='JavaScript'>alert('Collegamento allo stradario non riuscito. Ripova più tardi.'),history.go(-1)</script></html>");
?>


