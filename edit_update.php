<?php
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
include_once("include/config.php");
include_once("include/auth.lib.php");
include_once("include/utils.lib.php");
include_once("include/license.lib.php");
include_once ("include/form.function.php");
list($status, $user) = auth_get_status();
if ($status == AUTH_LOGGED) {
    if (license_has($user, "Inserimento")) {
        //mostrare form di inserimento
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //recupero dati dal form
            //query sul db 
            //mostra risultati
            $old_category=$_POST["vecchia_categoria"];
            $new_prot_generale = $_POST["protocollo_generale"];
            $prot_generale = $_POST["old_prot"];
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
                if (check_DB($categoria_ordinanza, $new_prot_generale) == 1) {//nella categoria selezionata esiste l'ordinanza da modificare
                    $query_ordinanze = pg_query(utf8_encode('UPDATE ordinanze '
                                    . 'SET "numero protocollo generale" = ' . $new_prot_generale . ','
                                    . '"numero di protocollo Comune" = \'' . $prot_comune . '\','
                                    . 'data= \'' . $dt_prot_gen . '\','
                                    . '"data protocollo Comune"=\'' . $dt_prot_comune . '\','
                                    . 'oggetto=\'' . $oggetto . '\','
                                    . 'topon=\'' . $toponimo . '\','
                                    . '"via/piazza"=\'' . $nome_via . '\','
                                    . 'codvia=' . $codvia . ','
                                    . '"note varie"=\'' . $note . '\','
                                    . 'civico=' . $num_civico . ','
                                    . 'lettcivico=\'' . $let_civico . '\''
                                    . 'WHERE "numero protocollo generale" = ' . $prot_generale . ''));
                    $query_categorie = pg_query(utf8_encode('UPDATE "' . $categoria_ordinanza . '" '
                                    . 'SET "numero protocollo generale"=' . $new_prot_generale . ','
                                    . 'oggetto = \'' . $oggetto . '\''
                                    . 'WHERE "numero protocollo generale"=' . $prot_generale . ''));
                } else { // nella categoria selezionata non esiste un ordinanza da modificare 
                    $query_ordinanze = pg_query(utf8_encode('UPDATE ordinanze '
                                    . 'SET "numero protocollo generale" = ' . $new_prot_generale . ','
                                    . '"numero di protocollo Comune" = \'' . $prot_comune . '\','
                                    . 'data= \'' . $dt_prot_gen . '\','
                                    . '"data protocollo Comune"=\'' . $dt_prot_comune . '\','
                                    . 'oggetto=\'' . $oggetto . '\','
                                    . 'topon=\'' . $toponimo . '\','
                                    . '"via/piazza"=\'' . $nome_via . '\','
                                    . 'codvia=' . $codvia . ','
                                    . '"note varie"=\'' . $note . '\','
                                    . 'civico=' . $num_civico . ','
                                    . 'lettcivico=\'' . $let_civico . '\''
                                    . 'WHERE "numero protocollo generale" = ' . $prot_generale . ''));
                    $query_categorie = pg_query(utf8_encode('DELETE FROM "'.$old_category.'" WHERE "numero protocollo generale" = ' . $prot_generale . ';'
                                    . 'INSERT INTO "' . $categoria_ordinanza . '" '
                                    . '("numero protocollo generale", oggetto)'
                                    . 'VALUES (' . $new_prot_generale . ',\'' . $oggetto . '\')'));
                }
                if ($query_ordinanze && $query_categorie) {
                    echo '<div class="alert alert-success" role="alert">Ordinanza N:' . $prot_generale . ' Modificata correttamente.</div>';
                    include("insert_form.php");
                } else {
                    if ($query_categorie) {
                        echo '<div class="alert alert-warning" role="alert">Caricamento avvenuto solo su categoria:' . $categoria_ordinanza . '</div>';
                        include("insert_form.php");
                    } else if ($query_ordinanze) {
                        echo '<div class="alert alert-warning" role="alert">Caricamento avvenuto solo su Ordinanze</div>';
                        include("insert_form.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Modifica non riuscita</div>';
                        include("insert_form.php");
                    }
                }
            } else { //query solo su tabella ordinanza per il caricamento
                $query_solo_ordinanze = pg_query(utf8_encode('UPDATE ordinanze '
                                . 'SET "numero protocollo generale" = ' . $new_prot_generale . ','
                                . '"numero di protocollo Comune" = \'' . $prot_comune . '\','
                                . 'data= \'' . $dt_prot_gen . '\','
                                . '"data protocollo Comune"=\'' . $dt_prot_comune . '\','
                                . 'oggetto=\'' . $oggetto . '\','
                                . 'topon=\'' . $toponimo . '\','
                                . '"via/piazza"=\'' . $nome_via . '\','
                                . 'codvia=' . $codvia . ','
                                . '"note varie"=\'' . $note . '\','
                                . 'civico=' . $num_civico . ','
                                . 'lettcivico=\'' . $let_civico . '\''
                                . 'WHERE "numero protocollo generale" = ' . $prot_generale . ''));
                if ($query_solo_ordinanze) {
                    echo '<div class="alert alert-success" role="alert">Ordinanza N:' . $prot_generale . ' Caricata correttamente su:' . $categoria_ordinanza . '</div>';
                    include("insert_form.php");
                } else {
                    echo '<div class="alert alert-danger" role="alert">Caricamento non riuscito</div>';
                    include("insert_form.php");
                }
            }
        } else {

            include("edit_form.php");
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