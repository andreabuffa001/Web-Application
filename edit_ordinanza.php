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
        include ("include/form.function.php");
        ?>
        <title>Archivio Ordinanze</title>
        <script>
            function scelta_via(that) {
                var i;
                var h;
                        switch (that.value) {
<?php
$query_zona = "SELECT REPLACE((REPLACE(zona,' ','')),'.','') NOSpazio, zona FROM DATA.VIA_T GROUP BY zona ORDER BY zona ASC";
$result_zona = oci_parse($con_stradario, $query_zona);
oci_execute($result_zona);
if ($result_zona) {
    while ($row = oci_fetch_array($result_zona)) {
        echo 'case "' . $row["0"] . '":
                      var hidden = document.getElementsByClassName("via");
                      console.log(typeof(hidden.value));
                      for (h=0;h<hidden.length;h++){
                        hidden[h].style.display="none";
                        }
                        var opt = document.getElementsByClassName("' . $row["0"] . '");
                          console.log(typeof(opt.size));
                          for (i=0;i<opt.length;i++){
                            opt[i].style.display="block";
                          }
                          break;
                          ';
    } //while
    //echo 'else {
    //var hidden = document.getElementsByTagName("option");
    //for (i=0;i<hidden.lenght;i++){
    //hidden[i].style.display="none";
    //console.log(i+" "+hidden[i]);
    //}
    //}';
} //if
?>
                    default:
                        var hidden = document.getElementsByClassName("via");
                        for (i = 0; i < hidden.lenght; i++) {
                            hidden[i].style.display = "none";
                        }
                    }
                }
                function scelta_civico(that) {
                    var i;
                    var h;
                    switch (that.value){
<?php
$query_civici = "SELECT VIA_T.topon, VIA_T.nomevia, VIA_T.idvia,CIV_ATTIVI.NUMLETCIV, CIV_ATTIVI.IDVIA, VIA_T.IDVIA FROM DATA.VIA_T INNER JOIN GWSBASE.CIV_ATTIVI ON CIV_ATTIVI.IDVIA = VIA_T.IDVIA";
$result_civici = oci_parse($con_stradario, $query_civici);
oci_execute($result_civici);
if ($result_civici) {
    while ($row = oci_fetch_array($result_civici)) {
        echo 'case "' . $row["0"] . '_' . $row["1"] . '_' . $row["2"] . '":
                      var hidden = document.getElementsByClassName("civico");
                      console.log(typeof(hidden.value));
                      for (h=0;h<hidden.length;h++){
                        hidden[h].style.display="none";
                      }
                        var opt = document.getElementsByClassName("' . $row["0"] . '_' . $row["1"] . '_' . $row["2"] . '");
                          console.log(typeof(opt.size));
                          for (i=0;i<opt.length;i++){
                            opt[i].style.display="block";
                          }
                          break;
                          ';
    } //while
    //echo 'else {
    //var hidden = document.getElementsByTagName("option");
    //for (i=0;i<hidden.lenght;i++){
    //hidden[i].style.display="none";
    //console.log(i+" "+hidden[i]);
    //}
    //}';
} //if
?>
                    default:
                            var hidden = document.getElementsByClassName("civico");
                    for (i = 0; i < hidden.length; i++) {
                        hidden[i].style.display = "none";
                    }
                }
            }
        </script>
    </head>
    <body>
        <?php
        include_once("include/config.php");
        include_once("include/auth.lib.php");
        include_once("include/utils.lib.php");
        include_once("include/license.lib.php");
        list($status, $user) = auth_get_status();
        if ($status == AUTH_LOGGED) {
            if (license_has($user, "Inserimento")) {
                //Menu
                //include("menu.php");
                ?>
                <!--Menu-->
                <form method="post" action="edit_update.php" id="insert_ord">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr class="form-group">
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $var_getdoc = $_POST['protocollo_hidden'];
                                        $query = 'select ordinanze."note varie",ordinanze.codvia, ordinanze.data, ordinanze.foto, ordinanze."collegamento al testo", ordinanze."numero protocollo generale", ordinanze."numero di protocollo Comune", ordinanze."data protocollo Comune", ordinanze.oggetto, ordinanze.topon, ordinanze."via/piazza" FROM ordinanze WHERE "numero protocollo generale" =' . $var_getdoc . '';
                                        $result = pg_query($query);
                                        if ($result) {
                                            while ($row_edit = pg_fetch_array($result)) {
                                                ?>
                                                <td>N&#176; Protocollo Generale</td>
                                                <td><input name="old_prot" type="hidden" value="<?php echo $row_edit["numero protocollo generale"]; ?>"><input value="<?php echo $row_edit["numero protocollo generale"]; ?>" type="text" class="form-control" name="protocollo_generale" placeholder="Numero di Protocollo Comunale"></td>
                                                <td>Data Protocollo Generale</td>
                                                <td><input value="<?php echo $row_edit["data"]; ?>" type="date" class="form-control" name="data_protocollo_generale"></td>
                                                <td>Servizio AEM <b>(non implementato)</b></td>
                                                <td>SI <input type="radio" name="servizioAEM" value="1"> NO <input type="radio" name="servizioAEM" value="0"></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>N&#176; Protocollo Comune</td>
                                                <td><input value="<?php echo $row_edit["numero di protocollo Comune"] ?>" type="text" class="form-control" name="protocollo_comune" placeholder="Numero di Protocollo Comunale"></td>
                                                <td>Data Protocollo comune</td>
                                                <td><input value="<?php echo $row_edit["data protocollo Comune"] ?>" type="date" class="form-control" name="data_protocollo_comune"></td>
                                                <td>Annullata <b>(non implementato)</b></td>
                                                <td>SI <input type="radio" name="annullata" value="si"> NO <input type="radio" name="annullata" value="si"></td>
                                            </tr>
                                            <tr class="form-group">
                                                <td>Carica Foto</td>
                                                <td><input type="file" name="pic" accept="image/*"></td>
                                                <td>Carica Doc Ordinanza</td>
                                                <td><input type="file" name="pic" accept="image/*"></td>
                                                <td>Note</td>
                                                <td><textarea name="note" type="textarea" rows="4" col="40" form="insert_ord" placeholder="Inserisci note.."><?php echo $row_edit["note varie"]; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>Corpo ordinanza</td>
                                                <td><textarea name="oggetto" type="textarea" rows="4" col="100" form="insert_ord"><?php
                                                        echo $row_edit["oggetto"];
                                                    }
                                                }
                                            }
                                            ?></textarea></td>
                                    <td>Categorie</td>
                                    <td colspan="3">
                                        <?php
                                        //recupero categoria ordinanza
                                        switch (categoria_ordinanza($var_getdoc)) {
                                            case 1:
                                                echo "<input type='hidden' name='vecchia_categoria' value='carico scarico'>";
                                                break;
                                            case 2:
                                                echo "<input type='hidden' name='vecchia_categoria' value='cs2'>";
                                                break;
                                            case 3:
                                                echo "<input type='hidden' name='vecchia_categoria' value='disabili giunta p'>";
                                                break;
                                            case 4:
                                                echo "<input type='hidden' name='vecchia_categoria' value='disabili giunta c'>";
                                                break;
                                            case 5:
                                                echo "<input type='hidden' name='vecchia_categoria' value='divieto_autocarri_2000'>";
                                                break;
                                            case 6:
                                                echo "<input type='hidden' name='vecchia_categoria' value='dossi'>";
                                                break;
                                            case 7:
                                                echo "<input type='hidden' name='vecchia_categoria' value='bus extraurbani'>";
                                                break;
                                            case 8:
                                                echo "<input type='hidden' name='vecchia_categoria' value='farmacia 11'>";
                                                break;
                                            case 9:
                                                echo "<input type='hidden' name='vecchia_categoria' value='piste_cicl'>";
                                                break;
                                            case 10:
                                                echo "<input type='hidden' name='vecchia_categoria' value='sensi'>";
                                                break;
                                        }
                                        ?>
                                        <input type="radio" name="categoria" value="ordinanze">Ordinanza Semplice<br>
                                        <input type="radio" name="categoria" value="carico scarico">Carico/Scarico<br>
                                        <input type="radio" name="categoria" value="cs2">CS2<br>
                                        <input type="radio" name="categoria" value="disabili giunta p">Disabili Giunta P<br>
                                        <input type="radio" name="categoria" value="disabili giunta c">Disabili Giunta C<br>
                                        <input type="radio" name="categoria" value="divieto_autocarri_2000">Divieto Autocarri<br>
                                        <input type="radio" name="categoria" value="dossi">Dossi<br>
                                        <input type="radio" name="categoria" value="bus extraurbani">Bus Extraurbani<br>
                                        <input type="radio" name="categoria" value="farmacia 11"> Farmacie<br>
                                        <input type="radio" name="categoria" value="piste_cicl">Piste Ciclabili<br>
                                        <input type="radio" name="categoria" value="sensi">Sensi Unici<br>
                                    </td>
                                </tr>
                                <tr class="form-group">
                                    <td>Zona</label></td>
                                    <td>
                                        <select id="zona" class="form-control" name="codvia" onchange="scelta_via(this);">
                                            <option value="0" selected="selected">Scegli zona..</option>
                                            <?php
                                            $query = "SELECT REPLACE((REPLACE(zona,' ','')),'.','') NOSpazio, zona FROM DATA.VIA_T GROUP BY zona ORDER BY zona ASC";
                                            $result = oci_parse($con_stradario, $query);
                                            oci_execute($result);
                                            if ($result) {
                                                while ($row_zona = oci_fetch_array($result)) {
                                                    echo "<option value='" . $row_zona["0"] . "'>" . $row_zona["1"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>Via</td>
                                    <td>
                                        <select id="via" class="form-control" name="via" onchange="scelta_civico(this);">
                                            <option value="0" selected="selected">Scegli via..</option>
                                            <?php
                                            $query_zone_select = "SELECT topon, nomevia, idvia, CONCAT(topon,REPLACE(REPLACE(nomevia,' ',''),'''','')) topocompleto, CONCAT(CONCAT(topon,' '),nomevia) topospazio, REPLACE((REPLACE(zona,' ','')),'.','') NOSpazio FROM DATA.VIA_T order by topospazio asc";
                                            $result_zone_select = oci_parse($con_stradario, $query_zone_select);
                                            oci_execute($result_zone_select);
                                            if ($result_zone_select) {
                                                while ($row_via = oci_fetch_array($result_zone_select)) {
                                                    echo "<option class='" . $row_via["5"] . " civico' value='" . $row_via["0"] . "_" . $row_via["1"] . "_" . $row_via["2"] . "' style='display:none;'>" . $row_via["4"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>Numero Civico</td>
                                    <td><select id="num_civico" class="form-control" name="civico">
                                            <option value="0" selected="selected">Scegli civico..</option>
                                            <?php
                                            $query_civici_select = "SELECT VIA_T.topon, VIA_T.nomevia, VIA_T.idvia, CIV_ATTIVI.NUMCIV, CIV_ATTIVI.LETCIV ,CIV_ATTIVI.IDVIA, VIA_T.IDVIA FROM DATA.VIA_T INNER JOIN GWSBASE.CIV_ATTIVI ON CIV_ATTIVI.IDVIA = VIA_T.IDVIA ORDER BY CIV_ATTIVI.NUMLETCIV ASC";
                                            $result_civici_select = oci_parse($con_stradario, $query_civici_select);
                                            oci_execute($result_civici_select);
                                            if ($result_civici_select) {
                                                while ($row_civico = oci_fetch_array($result_civici_select)) {
                                                    echo "<option class='" . $row_civico["0"] . "_" . $row_civico["1"] . "_" . $row_civico["2"] . " civico' value='" . $row_civico["3"] . "_" . $row_civico["4"] . "' style='display:none;'>" . $row_civico["3"] . " " . $row_civico["4"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><button type="update" class="btn btn-primary">Modifica</button></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                <?php
            }//utente con permessi inserimento
            else {
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
