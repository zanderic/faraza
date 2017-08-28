<!-- @autor Rappini Alessandro -->
<?php
	session_start();// come sempre prima cosa, aprire la sessione 
	include_once ("ConnessioneDB.php");
	global $_GLOBAL;

	$_SESSION["mail"]=$_POST["mail"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION username
	$_SESSION["password"]=$_POST["password"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION password
	
	try {
            $sql = ("SELECT * FROM faraza.utente WHERE email='".$_POST["mail"]."' AND password ='".$_POST["password"]."'")
                    OR DIE('query non riuscita'.mysql_error()); // messagio che sancisce che la query non è andata a buon fine
            $res=$_GLOBAL['pdo']->query($sql);
        } catch (Exception $ex) {
            echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
            exit();
        }
	
	// Con il SELECT qua sopra selezione dalla tabella users l utente registrato (se lo è) con i parametri che mi ha passato il form di login, quindi
	// Quelli dentro la variabile POST. username e password.
	if($res->fetch()){        //se c'è una persona con quel nome nel db allora loggati
		header("location:homeutente.php"); // e mando per esempio ad una pagina esempio.php// in questo caso rimanderò ad una pagina prova.php
	}else{
		//popup
        echo "<script language=\"javascript\">";
		echo "var answer = confirm(\"ERROE CREDENZIALI. \");";
		echo "(window.location='index.php'); ";
		echo "</script>";		
	}
?>