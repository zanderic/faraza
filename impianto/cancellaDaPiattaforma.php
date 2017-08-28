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
        session_start(); // come sempre prima cosa, aprire la sessione
        include_once ("../connessioneDB.php");
        global $_GLOBAL;
        
        try
        {
          $sql = 'DELETE FROM faraza.impiantosportivo WHERE ID = "'.$_SESSION["ID_Centro"].'"';
          $res = $_GLOBAL['pdo']->exec($sql);
                  echo '<script type="text/javascript">
                  alert("Cancellazione avvenuta con successo");
                  window.location.assign("../index.php")
                  </script>';
         
        } catch (PDOException $ex) {
            echo $sql . "<br>" . $e->getMessage();
        }
        finally
        {
            // chiudo la connessione;
            $_GLOBAL['pdo']= null;
        }
        ?>
    </body>
</html>
