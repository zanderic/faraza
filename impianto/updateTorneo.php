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
        include_once ("../connessioneDB.php");
        global $_GLOBAL;
        session_start();
                
        try {
            // Update Nome Torneo
//            $sqlUpdate = 'UPDATE `faraza`.`torneo` SET nome = "'.$_POST["NomeTorneoUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
//            $result = $_GLOBAL["pdo"]->query($sqlUpdate);
            // update Tipo
            $sqlUpdate1 = 'UPDATE `faraza`.`torneo` SET tipo  = "'.$_POST["TipoTorneoUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result1 = $_GLOBAL["pdo"]->query($sqlUpdate1);
            // update Costo
            $sqlUpdate2 = 'UPDATE `faraza`.`torneo` SET costo  = "'.$_POST["CostoTorneoUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result2 = $_GLOBAL["pdo"]->query($sqlUpdate2);
            // update Inizio Torneo
            $sqlUpdate3 = 'UPDATE `faraza`.`torneo` SET inizioTorneo  = "'.$_POST["InizioTorneoUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result3 = $_GLOBAL["pdo"]->query($sqlUpdate3);
            // update Fine Torneo
             $sqlUpdate4 = 'UPDATE `faraza`.`torneo` SET fineTorneo  = "'.$_POST["FineTorneoUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result4 = $_GLOBAL["pdo"]->query($sqlUpdate4);
            // update Inizio Iscrizioni 
            $sqlUpdate5 = 'UPDATE `faraza`.`torneo` SET inizioIscrizioni  = "'.$_POST["InizioIscrizioniUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result5 = $_GLOBAL["pdo"]->query($sqlUpdate5);
            // update Fine Iscrizioni
            $sqlUpdate6 = 'UPDATE `faraza`.`torneo` SET fineIscrizioni  = "'.$_POST["FineIscrizioniUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result6 = $_GLOBAL["pdo"]->query($sqlUpdate6);
            
            //update Numero Minimo Squadre
            $sqlUpdate7 = 'UPDATE `faraza`.`torneo` SET numeroMinimoSquadre  = "'.$_POST["NumSquadUpdate"].'" WHERE nome = "'.$_SESSION["TorneoScelto"].'"';
            $result7 = $_GLOBAL["pdo"]->query($sqlUpdate7);
            
            echo '<script type="text/javascript">
               window.location.assign("visualizzaTornei.php")
               </script>';
            
        } catch (PDOExceptionv $ex) {
            echo "Qualcosa non è andato..." . $ex->getMessage();
        }
        ?>
    </body>
</html>
