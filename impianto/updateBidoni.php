<!DOCTYPE html>
<!--
author Antonio Faienza
questo file aggiornerà i punti bonus
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
        $_SESSION["aggiornamento_bidoni"]=$_POST["pt_bonus"];
        try
        {
            $sqlBidoni = 'UPDATE `faraza`.`utente` SET `bidoni`='.$_POST["pt_bonus"].' WHERE `ID`='.$_SESSION['IDUtenteScelto'].'';
            $resBidoni = $_GLOBAL["pdo"]->query($sqlBidoni);
        } catch (PDOException $ex) {
             echo 'Lupdate dei bidoni non è andato a buon fine: ' .$ex->getMessage();
        }
		finally
		{
                    echo "<div class='alert alert-success' role='alert' align='middle'>Hai aggiornato i punti bonus
                    <br><br><a class='btn btn-success' href='homeImpiantoSportivo.php' role='button'>OK</a>	
                    </div>";
		}
        ?>
    </body>
</html>
