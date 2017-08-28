<!-- @autor Rappini Alessandro -->
<?php
            
			include_once ("../connessioneDB.php");
			global $_GLOBAL;
            session_start();
            $ID = $_SESSION["ID"];
            try             
	        {
	            $sql = "DELETE FROM faraza.utente WHERE  ID ='$ID' ";
	            $res=$_GLOBAL['pdo']->query($sql);
	        } catch (Exception $ex) {
	            echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
	            exit();
	        }
            
             header("location:index.php");       
?>