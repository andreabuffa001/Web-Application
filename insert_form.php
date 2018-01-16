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
<div class="panel panel-default">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#submit" id="insert_ord">
        <table class="table table-hover">
            <tr class="form-group">
                <td>N&#176; Protocollo Generale</td>
                <td><input type="text" class="form-control" name="protocollo_generale" placeholder="Numero di Protocollo Comunale"></td>
                <td>Data Protocollo Generale</td>
                <td><input type="date" class="form-control" name="data_protocollo_generale"></td>
                <td>Servizio AEM <b>(non implementato)</b></td>
                <td>SI <input type="radio" name="servizioAEM" value="1"> NO <input type="radio" name="servizioAEM" value="0"></td>
            </tr>
            <tr class="form-group">
                <td>N&#176; Protocollo Comune</td>
                <td><input type="text" class="form-control" name="protocollo_comune" placeholder="Numero di Protocollo Comunale"></td>
                <td>Data Protocollo comune</td>
                <td><input type="date" class="form-control" name="data_protocollo_comune"></td>
                <td>Annullata <b>(non implementato)</b></td>
                <td>SI <input type="radio" name="annullata" value="si"> NO <input type="radio" name="annullata" value="si"></td>
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
                            while ($row = oci_fetch_array($result)) {
                                echo "<option value='" . $row["0"] . "'>" . $row["1"] . "</option>";
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
                            while ($row2 = oci_fetch_array($result_zone_select)) {
                                echo "<option class='" . $row2["5"] . " civico' value='" . $row2["0"] . "_" . $row2["1"] . "_" . $row2["2"] . "' style='display:none;'>" . $row2["4"] . "</option>";
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
                            while ($row2 = oci_fetch_array($result_civici_select)) {
                                echo "<option class='" . $row2["0"] . "_" . $row2["1"] . "_" . $row2["2"] . " civico' value='" . $row2["3"] . "_" . $row2["4"] . "' style='display:none;'>" . $row2["3"] . " " . $row2["4"] . "</option>";
                            }
                        }
                        ?>
                    </select></td>
            </tr>
            <tr class="form-group">
                <td>Carica Foto</td>
                <td><input type="file" name="pic" accept="image/*"></td>
                <td>Carica Doc Ordinanza</td>
                <td><input type="file" name="pic" accept="image/*"></td>
                <td>Note</td>
                <td><textarea name="note" type="textarea" rows="4" col="40" form="insert_ord" placeholder="Inserisci note.."></textarea></td>
            </tr>
            <tr>
                <td>Corpo ordinanza</td>
                <td><textarea name="oggetto" type="textarea" rows="4" col="100" form="insert_ord" placeholder="Inserisci corpo ordinanza.."></textarea></td>
                <td>Categorie</td>
                <td colspan="3">
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
            <tr>
                <td><button type="submit" class="btn btn-primary">Carica</button></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>