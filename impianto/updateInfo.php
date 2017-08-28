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
        
        try {
            // Update Nome Centro
            $sql = 'UPDATE faraza.impiantoSportivo SET nomeCentro = "'.$_POST["NuovoNome"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result = $_GLOBAL["pdo"]->query($sql);
            $_SESSION['Nome_centro'] = $_POST["NuovoNome"];
            // update email
            $sql1 = 'UPDATE faraza.impiantoSportivo SET email  = "'.$_POST["NuovaMail"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result1 = $_GLOBAL["pdo"]->query($sql1);
            // update password
            $sql2 = 'UPDATE faraza.impiantoSportivo SET password  = "'.$_POST["NuovaPass"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result2 = $_GLOBAL["pdo"]->query($sql2);
            // update Costo Orario
            $sql3 = 'UPDATE faraza.impiantoSportivo SET costoOrario  = "'.$_POST["NuovoCosto"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result3 = $_GLOBAL["pdo"]->query($sql3);
            // update città
             $sql4 = 'UPDATE faraza.impiantoSportivo SET citta  = "'.$_POST["NuovaCitta"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result4 = $_GLOBAL["pdo"]->query($sql4);
            // update via 
            $sql5 = 'UPDATE faraza.impiantoSportivo SET via  = "'.$_POST["NuovaVia"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result5 = $_GLOBAL["pdo"]->query($sql5);
            // update civico
            $sql6 = 'UPDATE faraza.impiantoSportivo SET civico  = "'.$_POST["NuovoCivico"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result6 = $_GLOBAL["pdo"]->query($sql6);
            //update Cap
            $sql7 = 'UPDATE faraza.impiantoSportivo SET cap  = "'.$_POST["NuovoCap"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result7 = $_GLOBAL["pdo"]->query($sql7);
            // update Telefono
            $sql8 = 'UPDATE faraza.impiantoSportivo SET telefono  = "'.$_POST["NuovoTelefono"].'" WHERE ID = "'.$_SESSION["ID_Centro"].'"';
            $result8 = $_GLOBAL["pdo"]->query($sql8);
            echo '<script type="text/javascript">
                  window.location.assign("visualizzaInfo.php")
                  </script>';
            
        } catch (PDOExceptionv $ex) {
            echo "Qualcosa non è andato..." . $ex->getMessage();
        }
        ?>
    </body>
</html>
