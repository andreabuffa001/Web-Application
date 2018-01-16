<?php
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
include_once("include/config.php");
include_once("include/auth.lib.php");
include_once("include/utils.lib.php");
include_once("include/license.lib.php");
include("link.php");
include("conn.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Archivio Ordinanze</title>
    </head>
    <body>
        <!--Menu-->
        <?php include("menu.php") ?>
        <!--Menu-->
        <div class="container-fluid">
            <?php
            list($status, $user) = auth_get_status();
            if ($status == AUTH_LOGGED) {
                if (license_has($user, "Inserimento")) {
                    //mostrare form di inserimento
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        //recupero dati dal form
                        //query sul db 
                        //mostra risultati
                        $prot_generale = $_POST["protocollo_generale"];
                        $prot_comune = $_POST["protocollo_comune"];
                        $dt_prot_comune = $_POST["data_protocollo_comune"];
                        $dt_prot_gen = $_POST["data_protocollo_generale"];
                        $macro_via = $_POST["via"];
                        list ($toponimo, $nome_via, $codvia) = preg_split("/_/", $macro_via, -1, PREG_SPLIT_NO_EMPTY);
                        $macro_civico = $_POST["civico"];
                        list ($num_civico, $let_civico) = preg_split("/_/", $macro_civico, -1, PREG_SPLIT_NO_EMPTY);
                        $note = $_POST["note"];
                        $oggetto = $_POST["oggetto"];
                        $categoria_ordinanza = $_POST["categoria"];
                        if ($categoria_ordinanza != "ordinanze") { //doppia query per inserire parte delle variabili sulla categoria d'appartenzenza
                            $query_ordinanze = pg_query(utf8_encode('INSERT INTO ordinanze ("numero protocollo generale","numero di protocollo Comune",data,"data protocollo Comune",oggetto,topon,"via/piazza",codvia,"note varie",civico,lettcivico) VALUES (' . $prot_generale . ',\'' . $prot_comune . '\',\'' . $dt_prot_gen . '\',\'' . $dt_prot_comune . '\',\'' . $oggetto . '\',\'' . $toponimo . '\',\'' . $nome_via . '\',' . $codvia . ',\'' . $note . '\',' . $num_civico . ',\'' . $let_civico . '\')'));
                            $query_categorie = pg_query(utf8_encode('INSERT INTO "' . $categoria_ordinanza . '" ("numero protocollo generale",oggetto) VALUES (' . $prot_generale . ',\'' . $oggetto . '\')'));
                            if ($query_ordinanze && $query_categorie) {
                                echo '<div class="alert alert-success" role="alert">Ordinanza N:' . $prot_generale . ' Caricata correttamente.</div>';
                                include("insert_form.php");
                            } else {
                                if ($query_categorie) {
                                    echo '<div class="alert alert-warning" role="alert">Caricamento avvenuto solo su categoria</div>';
                                    include("insert_form.php");
                                } else if ($query_ordinanze) {
                                    echo '<div class="alert alert-warning" role="alert">CAricameno avvenuto solo su Ordinanze</div>';
                                    include("insert_form.php");
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Caricamento non riuscito</div>';
                                    include("insert_form.php");
                                }
                            }
                        } else { //query solo su tabella ordinanza per il caricamento
                            $query = pg_query(utf8_encode('INSERT INTO ordinanze ("numero protocollo generale","numero di protocollo Comune",data,"data protocollo Comune",oggetto,topon,"via/piazza",codvia,"note varie",civico,lettcivico) VALUES (' . $prot_generale . ',\'' . $prot_comune . '\',\'' . $dt_prot_gen . '\',\'' . $dt_prot_comune . '\',\'' . $oggetto . '\',\'' . $toponimo . '\',\'' . $nome_via . '\',' . $codvia . ',\'' . $note . '\',' . $num_civico . ',\'' . $let_civico . '\')'));
                            if ($query) {
                                echo '<div class="alert alert-success" role="alert">Ordinanza N:' . $prot_generale . ' Caricata correttamente.</div>';
                                include("insert_form.php");
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Caricamento non riuscito</div>';
                                include("insert_form.php");
                            }
                        }
                    } else {

                        include("insert_form.php");
                    }
                } else {
                    ?>
                    <div class="alert alert-warning" role="alert"><b>Attenzione!</b> Non hai i permessi necessari per visualizzare la pagina. <a href="mailto:adamo.bozzetti@comune.cremona.it">Richiedi permessi</a></div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-danger" role="alert"><b>Attenzione!</b> Non sei connesso per favore <a href="./login.php">Accedi</a></div>
                <?php
            }
            ?>
        </div>
    </body>
</html>
