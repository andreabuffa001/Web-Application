<!--Se le pagine totali sono più di 1...
stampo i link per andare avanti e indietro tra le diverse pagine!-->
<?php if ($all_pages > 1){?>
<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
  <?php if ($pag > 1){
    
    if (strcmp($_SERVER['PHP_SELF'], "/db_access/archive.php")== 0 || strcmp($_SERVER['PHP_SELF'], "/db_access/category.php")== 0 || strcmp($_SERVER['PHP_SELF'], "/db_access/revoche.php")== 0 ){
      echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pag=" . ($pag - 1) . "\" aria-label='Previous'>";
      echo "<span aria-hidden='true'>&laquo;</span></a></li>";
      
    }else
      {
        echo "<a href=\"" . $_SERVER['REQUEST_URI'] . "&pag=" . ($pag - 1) . "\" aria-label='Previous'>";
        echo "<span aria-hidden='true'>&laquo;</span></a></li>";
      }
  }
  // faccio un ciclo di tutte le pagine
  for ($p=1; $p<=$all_pages; $p++) {
    // per la pagina corrente non mostro nessun link ma la evidenzio in blod
    // all'interno della sequenza delle pagine
    if ($p == $pag) echo "<b>" . $p . "</b>&nbsp;";
    // per tutte le altre pagine stampo il link
    else {
    if (strcmp($_SERVER['PHP_SELF'], "/db_access/archive.php")== 0 || strcmp($_SERVER['PHP_SELF'], "/db_access/category.php")== 0 || strcmp($_SERVER['PHP_SELF'], "/db_access/revoche.php")== 0 ){
      echo "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?pag=" . $p . "\">";
      echo $p . "</a></li>&nbsp;";
      }else
      {
      echo "<li><a href=\"" . $_SERVER['REQUEST_URI'] . "&pag=" . $p . "\">";
      echo $p . "</a></li>&nbsp;";
      } 
    } 
  }
  if ($all_pages > $pag){
    if (strcmp($_SERVER['PHP_SELF'], "/db_access/archive.php" || strcmp($_SERVER['PHP_SELF'], "/db_access/category.php"))== 0 || strcmp($_SERVER['PHP_SELF'], "/db_access/revoche.php")== 0){
      echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?pag=" . ($pag - 1) . "\" aria-label='Previous'>";
      echo "<span aria-hidden='true'>&raquo;</span></a></li>";
      
    }else
      {
        echo "<a href=\"" . $_SERVER['REQUEST_URI'] . "&pag=" . ($pag - 1) . "\" aria-label='Previous'>";
        echo "<span aria-hidden='true'>&raquo;</span></a></li>";
      }
    }?>
   </ul>
</nav>
<?php 
}
  ?>