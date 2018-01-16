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
        <?php
        include_once("include/config.php");
        include_once("include/auth.lib.php");
        include_once("include/utils.lib.php");
        include_once("include/license.lib.php");
        include_once("include/form.function.php");
        list($status, $user) = auth_get_status();
        if ($status == AUTH_LOGGED) {
            if (license_has($user, "Inserimento")) {
                if (isset($_POST["conferma"])) {//cancellazione solo se viene cliccato il tasto di conferma
                    $var_getdoc = $_POST["protocollo_hidden_del"];
                    //query di ricerca e cancellazione ordinanza
                    $delete_ordinanza = pg_query(utf8_encode('DELETE FROM "ordinanze" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                    switch (categoria_ordinanza($var_getdoc)) {
                        case 1:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "carico scarico" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 2:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "cs2" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 3:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "disabili giunta p" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 4:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "disabili giunta c" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 5:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "divieto_autocarri_2000" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 6:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "dossi" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 7:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "bus extraurbani" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 8:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "farmacia 11" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 9:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "piste_cicl" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                        case 10:
                            $delete_query = pg_query(utf8_encode('DELETE FROM "sensi" WHERE "numero protocollo generale" =' . $var_getdoc . ''));
                            break;
                    }
                    echo "Cancellata ordinanza N:" . $var_getdoc;
                } else {//chiedere conferma per la cancellazione
                    $var_getdoc = $_POST['protocollo_hidden'];
                    echo "<div class='alert alert-warning' role='alert'>Vuoi davvero cancellare l'ordinanza N:" . $var_getdoc . "?</div>";
                    echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'><input type='hidden' value='" . $var_getdoc . "' name='protocollo_hidden_del'><button type='submit' class='btn btn-danger' name='conferma'><b>Elimina</b></button></form>";
                }
            } else {
                ?>
                <div class="alert alert-warning" role="alert"><b>Attenzione!</b> Non hai i permessi necessari per visualizzare la pagina. <a href="mailto:adamo.bozzetti@comune.cremona.it">Richiedi permessi</a></div>
                <?php
            }
        }//utente loggato
        else {
            ?>
            <div class="alert alert-danger" role="alert"><b>Attenzione!</b> Non sei connesso per favore <a href="./login.php">Accedi</a></div>
            <?php
        }
        ?>
    </body>
</html>