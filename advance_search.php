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
            <div class='panel panel-default col-md-8' id="search">
                <!--mostra dei risultati-->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //recupero dati dal form
                    //query sul db 
                    //mostra risultati
                    $prot_comune = $_POST["protocollo_comune"];
                    $dt_prot_comune = $_POST["data_protocollo_comune"];
                    $dt_prot_gen = $_POST["data_protocollo_generale"];
                    $nome_via = $_POST["via"];
                    $codvia = $_POST["codvia"];
                    $civico = $_POST["num_civico"];
                    //$servizioAEM = $_POST["servizioAEM"];
                    //$revoca = $_POST["annullata"];
                    if (!empty($prot_comune)) {
                        $query_1 = 'CAST("numero di protocollo Comune" as TEXT) LIKE \'%' . $prot_comune . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_1 = "";
                    }
                    if (!empty($dt_prot_comune) && !empty($query_1)) {
                        $query_2 = 'OR "data protocollo Comune" LIKE \'%' . $dt_prot_comune . '%\''; //VAR PRESE DA IF NON VUOTI
                    } elseif (!empty($dt_prot_comune) && empty($query_1)) {
                        $query_2 = '"data protocollo Comune" LIKE \'%' . $dt_prot_comune . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_2 = "";
                    }
                    if (!empty($dt_prot_gen) && !empty($query_2)) {
                        $query_3 = 'OR data LIKE \'%' . $dt_prot_gen . '%\''; //VAR PRESE DA IF NON VUOTI
                    } elseif (!empty($dt_prot_gen) && empty($query_2)) {
                        $query_3 = 'data LIKE \'%' . $dt_prot_gen . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_3 = "";
                    }
                    if (!empty($nome_via) && !empty($query_3)) {
                        $query_4 = 'OR "via/piazza" LIKE \'%' . $nome_via . '%\''; //VAR PRESE DA IF NON VUOTI
                    } elseif (!empty($nome_via) && empty($query_3)) {
                        $query_4 = '"via/piazza" LIKE \'%' . $nome_via . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_4 = "";
                    }
                    if (!empty($codvia) && !empty($query_4)) {
                        $query_5 = 'OR CAST(codvia as TEXT) LIKE \'%' . $codvia . '%\''; //VAR PRESE DA IF NON VUOTI
                    } elseif (!empty($codvia) && empty($query_4)) {
                        $query_5 = 'CAST(codvia as TEXT) LIKE \'%' . $codvia . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_5 = "";
                    }
                    if (!empty($civico) && !empty($query_4)) {
                        $query_6 = 'OR civico LIKE \'%' . $civico . '%\' OR oggetto LIKE \'%civico ' . $civico . '%\' OR oggetto LIKE \'%civ. ' . $civico . '%\''; //VAR PRESE DA IF NON VUOTI
                    } elseif (!empty($civico) && empty($query_4)) {
                        $query_6 = 'civico LIKE \'%' . $civico . '%\' OR oggetto LIKE \'%civico ' . $civico . '%\' OR oggetto LIKE \'%civ. ' . $civico . '%\''; //VAR PRESE DA IF NON VUOTI
                    } else {
                        $query_6 = "";
                    }
                    // Recupero il numero di pagina corrente.
                    // Generalmente si utilizza una querystring
                    $pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
                    if (!$pag || !is_numeric($pag))
                        $pag = 1;
                    $query = 'Select * FROM ordinanze WHERE ' . $query_1 . '' . $query_2 . '' . $query_3 . '' . $query_4 . '' . $query_5 . '' . $query_6 . '';
                    // Uso mysql_num_rows per contare il totale delle righe presenti all'interno della tabella agenda
                    $result = pg_query($query);
                    $all_rows = pg_num_rows(pg_query($query));
                    $all_pages = ceil($all_rows / 20);
                    $first = ($pag - 1) * 20;
                    $rs = pg_query('Select * FROM ordinanze WHERE ' . $query_1 . '' . $query_2 . '' . $query_3 . '' . $query_4 . '' . $query_5 . '' . $query_6 . ' ORDER BY ordinanze."numero protocollo generale" DESC LIMIT 25 OFFSET ' . $first . '');
                    $nr = pg_num_rows($rs);
                    if ($nr != 0) {
                        ?><div class='row'><?php
                            for ($x = 0; $x < $nr; $x++) {
                                $row = pg_fetch_array($rs);
                                $img = "file://///srv-file/mob-pubb/ordinanze/" . $row["foto"];
                                $newdate = date('d-m-Y', strtotime($row["data"]));
                                echo "<div class='col-sm-6 col-md-4'><div class='thumbnail'><img src='logo.gif'><div class='caption'><h3>ORDINANZA DEL: " . $newdate . " <br>N&#176;: " . $row["numero protocollo generale"] . "</h3><p>(Protocollo Comune N&#176;:" . $row["numero di protocollo Comune"] . ")</p><p><a value='" . $row["numero protocollo generale"] . "' class='btn btn-primary fancybox fancybox.iframe' href='./get_doc_ordinanza.php?num_pro=" . $row["numero protocollo generale"] . "' >Visualizza ordinanza</a></p></div></div></div>";
                            }
                            ?></div><?php
                    } else {
                        echo "Nessun record trovato!";
                    }
                    include("pagination.php");
                    echo "</div>";
                    include("form.php"); //NON TOCCARE!!!!!
                } else {
                    ?>
                    <!--barra di ricerca avanzata-->
                </div>
            <?php include("form.php"); ?>
            </div>
            <?php
        }
        ?>
    </body>
</html>