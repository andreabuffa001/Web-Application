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
        <title>Ordinanza</title>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <!--query php-->
        <?php
        $protocollo = $_GET['num_pro'];
        $query = 'select ordinanze.codvia, ordinanze.data, ordinanze.foto, ordinanze."collegamento al testo", ordinanze."numero protocollo generale", ordinanze."numero di protocollo Comune", ordinanze."data protocollo Comune", ordinanze.oggetto, ordinanze.topon, ordinanze."via/piazza" FROM ordinanze WHERE "numero protocollo generale" =' . $protocollo . '';
        $result = pg_query($query);
        if ($result) {
            while ($row = pg_fetch_array($result)) {
                $newdate = date('d-m-Y', strtotime($row["data"]));
                $query_stradario = 'SELECT VIA_T.lunghezza, VIA_T.zona, VIA_T.ubicazione, VIA_T.tipocarreg, VIA_T.direzmarcia, VIA_T.note FROM DATA.VIA_T WHERE idvia=' . $row["codvia"] . '';
                $res_stradario = oci_parse($con_stradario, $query_stradario);
                oci_execute($res_stradario);
                if ($res_stradario) {
                    while ($row_strad = oci_fetch_array($res_stradario)) {
                        echo
                        "<div class='panel panel-info'>"
                        . "<div class='panel-heading'>"
                        . "<h3 class='panel-title'>"
                        . "<b>Ordinanza del:" . $newdate . " N&#176;:" . $row["numero protocollo generale"] . " Per " . $row["topon"] . " " . $row["via/piazza"] . "</b>"
                        . "</h3>"
                        . "</div>"
                        . "<div class='panel-body'>Oggetto:<br>" . $row["oggetto"] . "<br>"
                        . "<b>Lunghezza: </b>" . $row_strad[0] . "mt<br>"
                        . "<b>Zona: </b>" . $row_strad[1] . "<br>"
                        . "<b>Ubicazione: </b>" . $row_strad[2] . "<br>"
                        . "<b>Direzione di marcia: </b>" . $row_strad[4] . "<br>"
                        . "<b>Tipo di carregiata: </b>" . $row_strad[3] . "<br>"
                        . "<b>Note: </b>" . $row_strad[5] . "<br>"
                        . "<table><tr>"
                        . "<td><a class='btn btn-primary' href='file://///srv-file/mob-pubb/ordinanze/" . $row["foto"] . "' download='" . $row["numero protocollo generale"] . "_" . $newdate . "_foto'><b>Foto</b></a>&nbsp;</td>"
                        . "<td><a class='btn btn-info' href='file://///srv-file/mob-pubb/ordinanze/" . $row["collegamento al testo"] . "' download='" . $row["numero protocollo generale"] . "_" . $newdate . "_cartaceo'><b>Scarica Ordinanza</b></a></td>"
                        . "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>"
                        . "<td><form action='edit_ordinanza.php' method='post'><input name='protocollo_hidden' type='hidden' value='" . $row["numero protocollo generale"] . "'><button type='submit' class='btn btn-warning'><b>Modifica</b></button>&nbsp;</form></td>"
                        . "<td><form action='delete_ordinanza.php' method='post'><input name='protocollo_hidden' type='hidden' value='" . $row["numero protocollo generale"] . "'><button type='submit' class='btn btn-danger'><b>Elimina</b></button></form></td>"
                        . "</tr></table>"
                        . "</div>"
                        . "</div>";
                    }
                }
            }
        }
        ?> 
    </body>
</html>


