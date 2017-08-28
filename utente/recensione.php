<!-- @autor Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();

    $data = date("Y-m-d"); //stinga  
    //Vedo se l'utente ha gia inserito una recensione dello stesso impianto nella stessa giornata
    $ID = $_SESSION["ID"];
    $Impianto = $_POST["num"];

    try {
              $sql =("SELECT * FROM faraza.recensione WHERE data='$data' AND IDUtente ='$ID'  AND  IDImpiantoSportivo= '$Impianto' ")
              OR DIE('query non riuscita'.mysql_error()); // messagio che sancisce che la query non è andata a buon fine
              $res=$_GLOBAL['pdo']->query($sql);
        } catch (Exception $ex) {
              echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
              exit();
        }

    if (!($res->fetch())) {

        if ($_POST["num"] != "" && $_POST["recensione"] != "") {  // se i parametri iscritto non sono vuoti non sono vuote
           
             try {
                      $sql =("INSERT INTO faraza.recensione (data , voto , commento , IDUtente , IDImpiantoSportivo)
                            VALUES ('" . $data . "' , '" . $_POST["voto"] . "','" . $_POST["recensione"] . "', '" . $_SESSION["ID"] . "' ,'" . $_POST["num"] . "')") // scrivo sul DB questi valori
                            or die('<script type="text/javascript">
                                  alert("ERR-01 : Errore inserimento caratteri , riprova");
                                  window.location.assign("recensioneimpianto.php")
                                  </script>'); // se la query fallisce mostrami questo errore 
                       $res=$_GLOBAL['pdo']->query($sql);
                  } catch (Exception $ex) {
                       echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
                       exit();
                  }

            echo '<script type="text/javascript">
                  alert("Recensione inserita");
                  window.location.assign("homeutente.php")
                  </script>';
        } else {

            echo '<script type="text/javascript">
                  alert("ERR-02 :Errore inserimento caratteri , riprova");
                  window.location.assign("recensioneimpianto.php")
                  </script>';
        }
    } else {
        echo '<script type="text/javascript">
              alert("ERR-03 :Hai già inserito una recensione di questo impianto nella giornata di oggi, ne puoi inserire al massimo una al giorno per impianto");
              window.location.assign("recensioneimpianto.php")
              </script>';
    }
?>
