<!DOCTYPE html>
<!--
author Antonio Faienza
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start(); // come sempre prima cosa, aprire la sessione
        include_once ("../connessioneDB.php");
        global $_GLOBAL;
        try
        {
          $i = 1;
          
            for($j = 0; $j < count($_SESSION['arrayid']); $j++)
            {
                $sqlUpdatePunteggio1 = 'UPDATE faraza.partitatorneo set punteggioSquadraA = '.$_POST['punteggio'.$i.''].' WHERE ID='.$_SESSION['arrayid'][$j].' AND nomeTorneo = "'.$_SESSION["Veditorneo"].'"';                                 
                $resPunteggio1 = $_GLOBAL["pdo"]->query($sqlUpdatePunteggio1); 
                $i = $i+2;
            }
        $r = 2;    
            for($j = 0; $j < count($_SESSION['arrayid']); $j++)
            { 
                $sqlUpdatePunteggio2 = 'UPDATE faraza.partitatorneo set punteggioSquadraB = '.$_POST['punteggio'.$r.''].' WHERE ID='.$_SESSION['arrayid'][$j].' AND nomeTorneo = "'.$_SESSION["Veditorneo"].'"';                                 
                $resPunteggio2 = $_GLOBAL["pdo"]->query($sqlUpdatePunteggio2); 
                $r = $r+2;
            }
            
        } catch (PDOException $ex) {
            echo 'Update punteggio partite torneo non andato a buon fine ' .$ex->getMessage();
        }
        finally
        {
            header('location:visualizzaTornei.php');
        }
        
        ?>
    </body>
</html>
