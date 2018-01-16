<div class="panel panel-default col-md-4">
			 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#search">
				<div class="form-group">
    				<label for="exampleInputName2">N&#176; Protocollo Comune</label>
    				<input type="text" class="form-control" name="protocollo_comune" placeholder="Numero di Protocollo Comunale">
  				</div>
  				<div class="form-group">
    				<label for="exampleInputEmail2">Data Protocollo comune</label>
    				<input type="date" class="form-control" name="data_protocollo_comune" placeholder="Tutte le ordinanze emanate in data (protocollo comune)">
  				</div>
  				<div class="form-group">
    				<label for="exampleInputEmail2">Data Protocollo Generale</label>
    				<input type="date" class="form-control" name="data_protocollo_generale" placeholder="Tutte le ordinanze emanate in data (protocollo generale)">
  				</div>
  				<div class="form-group">
    				<label for="exampleInputEmail2">Via</label>
    				<input type="text" class="form-control" name="via" placeholder="Tutte le ordinanze contenenti la via">
  				</div>
  				<div class="form-group">
    				<label for="exampleInputEmail2">CodVia</label>
    				<input type="text" class="form-control" name="codvia" placeholder="Tutte le ordinanze appartenenti al codice via">
  				</div>
  				<div class="form-group">
    				<label for="exampleInputEmail2">Numero Civico</label>
    				<input type="text" class="form-control" name="num_civico" placeholder="Tutte le ordinanze contenenti il civico">
  				</div>
  				<div class="form-group">
    				<table class="table table-bordered">
    					<tr class="active">
    						<td>Servizio AEM<b>(non implementato</b></td>
    						<td>Annullata<b>(non implementato</b></td>
    					</tr>
    					<tr>
    						<td>SI <input type="radio" name="servizioAEM" value="1"></td>
    						<td>SI <input type="radio" name="annullata" value="si"></td>
    					</tr>
    					<tr>
    						<td>NO <input type="radio" name="servizioAEM" value="0"></td>
    						<td>NO <input type="radio" name="annullata" value="no"></td>    							
    					</tr>
    				</table>
    			</div>
  				<button type="submit" class="btn btn-default">Ricerca</button>
			 </form>
			</div>