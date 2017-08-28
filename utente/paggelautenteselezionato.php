<!-- @autor Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start(); 

    $sql = "SELECT *
            FROM faraza.pagellapartitatorneo
            WHERE IDUtenteVotante= '".$_SESSION["ID"]."' AND IDGiocatore= '".$_POST["idutente"]."' AND IDPartitaTorneo = '".$_SESSION["ID_partita"]."'";    
    $res=$_GLOBAL['pdo']->query($sql);
    $ris = $res -> fetch();
    echo $ris[0];
    
    if($ris){
        echo '<script type="text/javascript">
              alert("Hai gia recensione questo utente in questa partita");
              window.location.assign("homeutente.php")
              </script>';
    }else{
        try             
        {
           $sql = "INSERT INTO pagellapartitatorneo (voto, commento , IDUtenteVotante, IDGiocatore, IDPartitaTorneo , visto)
                   VALUES ('".$_POST["voto"]."','".$_POST["commento"]."','".$_SESSION["ID"]."','".$_POST["idutente"]."','".$_SESSION["ID_partita"]."' , 'false')";    
                   $res=$_GLOBAL['pdo']->query($sql);
                   echo '<script type="text/javascript">
                         alert("Recensione inserita");
                         window.location.assign("homeutente.php")
                         </script>';
        } catch (Exception $ex) {
                   echo '<script type="text/javascript">
                         alert("Errore nell inserimento riprova");
                         window.location.assign("homeutente.php")
                         </script>';
                   exit();
        }
    }
    
?>
