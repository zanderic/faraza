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
        $sql = 'DELETE FROM faraza.torneo WHERE (nome = "'.$_SESSION["DeleteNomeTorneo"].'")';
        $risultato = $_GLOBAL['pdo']->exec($sql);
        } catch (PDOException $ex) {
            echo "Qualcosa nella cancellazione non è andato: " .$ex->getMessage();
        }
        finally
        {
            echo '<script type="text/javascript">
               window.location.assign("VisualizzaTornei.php")
               </script>';
        }
        ?>
    </body>
</html>
