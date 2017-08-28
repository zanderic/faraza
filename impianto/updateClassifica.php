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

        try {
            $t = 1;
            for ($n = 0; $n < count($_SESSION['arrayid_squadra']); $n++) {
                $sqlClassifica = 'UPDATE faraza.squadra SET punti=' . $_POST['punti' . $t . ''] . ', partiteVinte=' . $_POST['partite_vinte' . $t . ''] . ', partitePerse=' . $_POST['partite_perse' . $t . ''] . ', partitePareggiate=' . $_POST['partite_pareggiate' . $t . ''] . ', goalFatti=' . $_POST['goal_fatti' . $t . ''] . ', goalSubiti=' . $_POST['goal_subiti' . $t . ''] . ' WHERE ID='.$_SESSION['arrayid_squadra'][$n].'';
                $risultatoClassifica = $_GLOBAL["pdo"]->query($sqlClassifica);
                $t = $t + 1;
            }
        }catch(PDOException $ex) {
                echo 'Aggiornamento classifica non andato a buon fine ' . $ex->getMessage();
        }
        finally
        {
            header('location:visualizzaTornei.php');
        }
?>
    </body>
</html>
