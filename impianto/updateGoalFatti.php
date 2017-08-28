<!DOCTYPE html>
<!--
author antonio faienza
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
        // Per evitare di dover fare un array muldidimensionale, nel momento in cui devono essere aggiornati tutti i goal
        // viene fatto un ciclo for che ad ogni iterazione fa una select di tutti quelli che sono i giocatori della squadra
        // denotata dall'indice dell' iterazione (il ciclo itera gli id delle squadre di quel torneo e viene creato nel file
        // visualizzaSquadre.php). A questo punto per ogni giocatore selezionato viene aggiornato il punteggio.
        // Il valore scelto è frutto della variabile che cambia nome dinamicamente.
         $r = 1;
        try {
                for($a = 0; $a < count($_SESSION['arrayid_squadra']); $a++)
                {
                    $sqlPlayerForTeam = 'SELECT IDGiocatore
                                        FROM faraza.giocatore
                                        WHERE IDSquadra= '.$_SESSION['arrayid_squadra'][$a].'';
                    $resPlayerForTeam = $_GLOBAL['pdo']->query($sqlPlayerForTeam);
                    while($rowPlayerForTeam = $resPlayerForTeam->fetch()){
                        $sqlUpdateGoal = 'UPDATE faraza.giocatore SET goalFatti='.$_POST['goal_fatti'.$r.''].' WHERE `IDGiocatore`='.$rowPlayerForTeam['IDGiocatore'].' AND`IDSquadra`='.$_SESSION['arrayid_squadra'][$a].'';
                        $resUpdateGoal = $_GLOBAL['pdo']->query($sqlUpdateGoal);
                        $r=$r+1;
                    }

                }
        } catch (PDOException $ex) {
            echo 'aggiormanto goal fatti ' .$ex->getMessage();
        }
        finally
        {
            header('location:visualizzaTornei.php');
        }
        ?>
    </body>
</html>
