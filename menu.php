<?php
include_once("include/config.php");
include_once("include/auth.lib.php");
include_once("include/utils.lib.php");
include_once("include/license.lib.php");

list($status, $user) = auth_get_status();
if($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK){
  $link = "?uid=".$_GET['uid'];
}else $link = '';
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="archive.php"><span class="glyphicon glyphicon-hdd" aria-hidden="true"></span></a>
    </div>
<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="archive.php">Archivio<span class="sr-only"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Altre funzioni<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="category.php">Categorie</a></li>
            <li><a href="revoche.php">Ordinanze Revocate</a></li>
            <li><a href="conteggi.php">Conteggi</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="stradario.php">Stradario</a></li>
          </ul>
        </li>
        <li><a href="advance_search.php">Ricerca Avanzata</a></li>
      </ul>
      <form method="GET" class="navbar-form navbar-left" action="search.php">
        <div class="form-group">
          <input name="key_protocollo" type="text" class="form-control" placeholder="Inserisci Numero Protocollo Generale">
        </div>
        <button type="submit" class="btn btn-default">Ricerca</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
            <?php
              switch($status){
                case AUTH_LOGGED:
                  ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utente: <?=$user["name"];?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php 
                  if (license_has($user,"Inserimento") || license_has($user,"Stradario") || license_has($user,"amministrazione")){
                    if (license_has($user,"Inserimento") && license_has($user,"Stradario") && license_has($user,"amministrazione")){
                      ?>
                          <li><a href="insert_ordinanza.php">Carica Ordinanza</a></li>
                          <li><a href="delete_ordinanza.php">Elimina Ordinanza</a></li>
                          <li><a href="edit_list_ordinanza.php">Modifica Ordinanza</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="update_stradario.php">Aggiorna Stradario</a></li>
                          <li><a href="admin.php">Amministrazione</a></li>
                  </ul>
                    <?php
                  }
                    elseif (license_has($user,"Inserimento") && license_has($user,"Stradario")){
                      ?>
                        <li><a href="insert_ordinanza.php">Carica Ordinanza</a></li>
                          <li><a href="delete_ordinanza.php">Elimina Ordinanza</a></li>
                          <li><a href="edit_ordinanza.php">Modifica Ordinanza</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="update_stradario.php">Aggiorna Stradario</a></li>
                  </ul>
                    <?php
                  }
                    elseif(license_has($user,"Stradario")){
                      ?>
                          <li><a href="update_stradario.php">Aggiorna Stradario</a></li>
                  </ul>
                    <?php
                  }
                    
                    elseif (license_has($user,"Inserimento")){
                    ?>
                          <li><a href="insert_ordinanza.php">Carica Ordinanza</a></li>
                          <li><a href="delete_ordinanza.php">Elimina Ordinanza</a></li>
                          <li><a href="edit_ordinanza.php">Modifica Ordinanza</a></li>
                  </ul>
                    <?php
                    }
                    elseif (license_has($user,"amministrazione")){
                      ?>
                          <li><a href="admin.php">Amministrazione</a></li>
                  </ul>
                    <?php
                    }
                    else{ 
                    ?>
                          <li><a href="mailto:adamo.bozzetti@comune.cremona.it">Richiedi permessi</a><li>
                  </ul>
                    <?php 
                    }
                  }
                  else{ 
                ?>
                          <li><a href="mailto:adamo.bozzetti@comune.cremona.it">Richiedi permessi</a><li>
                  </ul><?php 
                }
                ?>
              </li>
              <li><a href="logout.php<?=$link?>">Logout</a></li>
            <?php
            break;
            case AUTH_NOT_LOGGED:
            ?>
              <li><a href="login.php" type="button" class="btn">Accedi</a></li>
              <li><a href="registrati.php">Registrati</a></li>
          <?php
           break;
           }
        ?>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>