<!-- @author Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();

    $numero = array();
    $cont = 1;
    $sql = "SELECT * FROM faraza.recensione, faraza.impiantoSportivo WHERE recensione.IDImpiantoSportivo = impiantoSportivo.ID AND IDUtente ='".$_SESSION["ID"]."'";
    $result = $_GLOBAL['pdo']->query($sql);
    while ($row = $result->fetch()) {
        $numero[$cont] = $row;
        $cont++;
    }

    $riga = $numero[$_POST["id_campo"]];

    // Procedo ad eliminare la relazione
    try {
		$sql = "DELETE FROM faraza.recensione WHERE data='".$riga["data"]."' AND IDUtente = '".$_SESSION["ID"]."' AND IDImpiantoSportivo = '".$riga["IDImpiantoSportivo"]."' ";
		$res=$_GLOBAL['pdo']->query($sql);
    } catch (Exception $ex) {
      echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
      exit();
    }
    echo '<script type="text/javascript">
          alert("Recensione eliminata");
          window.location.assign("visualizzarecensioni.php")
          </script>';
?>