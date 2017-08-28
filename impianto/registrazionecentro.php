<!DOCTYPE html>
<!--
author Antonio Faienza
pagina di registtrazione all'impianto sportivo
-->
<html>
    <head>
		<title>Faraza - Registrazione</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../style.css">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
<?php
    session_start(); // come sempre prima cosa, aprire la sessione
    include_once ("../connessioneDB.php");
    include_once ('../email.php');
    
    global $_GLOBAL;

    $_SESSION['email'] = $_POST["email_c"];
    $_SESSION["password"] = $_POST["passw1_c"];
    $_SESSION["ripetipassword"] = $_POST["c_password2"];
    $_SESSION["Nome_centro"] = $_POST["nome_c"];
    $_SESSION["città"] = $_POST["citta"];
    $_SESSION["via"] = $_POST["via"];
    $_SESSION["civico"] = $_POST["civico"];
    $_SESSION["cap"] = $_POST["cap"];
    $_SESSION["cell"] = $_POST["cellulare_c"];
    $_SESSION["costoorario"] = $_POST["costo"];
    // Varibili relative agli errori nell'immissione dei campi
    $_SESSION['variabileErrore'] = "";
    $_SESSION['p1'] = "";       
    
    $_SESSION["NumeroCampi"] = $_POST["SceltaNumeroCampi"]; // inserimento numero campi
           
    // Controllo email
    try {
        // impianto
        $stmt = $_GLOBAL['pdo']->prepare('CALL verificaMailImpianto( ? ,@booleanv)'); // preparo la chimata alla store procedure
        $stmt->bindParam(1, $_SESSION['email'], $_GLOBAL['pdo']::PARAM_STR, 4000); // definisco i parametri;   
        // utente    
        $stmt2 = $_GLOBAL['pdo']->prepare('CALL verificaMailUtente( ? ,@booleant)'); // preparo la chimata alla store procedure
        $stmt2->bindParam(1, $_SESSION['email'], $_GLOBAL['pdo']::PARAM_STR, 4000);     
        // call the stored procedure impianto
        $stmt->execute();
        $result = $_GLOBAL['pdo']->query('SELECT @booleanv');
        $row = $result->fetch();
        
        // call the stored procedure utente
        $stmt2->execute();
        $result2 = $_GLOBAL['pdo']->query('SELECT @booleant');
        $row2 = $result2->fetch();
        
    } catch (PDOException $ex) {
        echo "Qualcosa nella STORE PROCEDURE verificaMail non è andato" .$ex->getMessage();
    }
        $outputbooleano = $row['@booleanv'];
        $outputbooleano2 = $row2['@booleant'];
        
    if (($outputbooleano==TRUE) OR ($outputbooleano2==TRUE)) { 
        $_SESSION['variabileErrore'] = "Mail già in uso";
		echo "<div class='alert alert-danger' role='alert' align='middle'>Email gia' in uso, inserire un'altra email.
				<br><br><a class='btn btn-danger' href='../index.php' role='button'>OK</a>
				</div>";
        exit();
    } else if($_SESSION["password"]!= $_SESSION["ripetipassword"] ) {
        $_SESSION['p1'] = "Le password non corrispondono";
        echo "<div class='alert alert-danger' role='alert' align='middle'>La conferma della password non corrisponde, controllare i campi password.
				<br><br><a class='btn btn-danger' href='../index.php' role='button'>OK</a>
				</div>";
        exit();
    } else {
		try {
			$sql = 'INSERT INTO faraza.impiantoSportivo(nomeCentro, email, password, costoOrario, citta, via, civico, cap, telefono) '
	                . 'VALUES("' . $_SESSION["Nome_centro"] . '","' . $_SESSION['email'] . '","' . $_SESSION["password"] . '","' . $_SESSION["costoorario"] . '","' . $_SESSION["città"] . '", "' . $_SESSION["via"] . '", "' . $_SESSION["civico"] . '" , "' . $_SESSION["cap"] . '", "' . $_SESSION["cell"] . '")';
	        $res = $_GLOBAL['pdo']->exec($sql);
	        // se la query è andata a buon fine....
			echo "<div class='alert alert-success' role='alert' align='middle'>Registrazione avvenuta con successo!<br>Ricevera' una email di conferma.
				<br><br><a class='btn btn-success' href='homeImpiantoSportivo.php' role='button'>OK</a>
				</div>";
	       
	        // Invio della mail all'utente registrato;
	        $subject = "FARAZA - Registrazione";
	        $messaggio = "La registrazione effettuata su FARAZA e' avvenuta con successo, le sue credenziali sono:<br><br>Email: ".$_SESSION['email']."<br>Password: ".$_SESSION["password"];
	        echo sendmail($_SESSION['email'], $subject, $messaggio); // invio mail
	        
	    } catch (PDOException $ex) {
	        echo("Errore nella query: " . $ex->getMessage());
	        exit();
		}
	}
        
    // Selezione dell'ID appena creato
    try {
        $sql2 = 'SELECT ID FROM faraza.impiantosportivo WHERE (email= "'.$_SESSION['email'].'")';
        $res = $_GLOBAL["pdo"]->query($sql2);
    } catch (PDOException $ex) {
        echo "Qualcose nella select in registrazione centro non è andato" .$ex->getMessage();
    }
    
    $row = $res->fetch();
    // Recupero l'ID dell'impianto appena creato
    if($row['ID']) {
        $_SESSION['ID_Centro'] = $row['ID'];
    }
    
    // Call store procedure per creare i campi relativi a ogni singolo centro;
    try {
        $stmtCampo = $_GLOBAL['pdo']->prepare('CALL inserisciCampo(?,?)');
        $stmtCampo->bindParam(1,$_SESSION["NumeroCampi"], $_GLOBAL['pdo']::PARAM_STR, 4000);
        $stmtCampo->bindParam(2,$_SESSION['ID_Centro'], $_GLOBAL['pdo']::PARAM_STR, 4000); 
        $stmtCampo->execute();
    } catch (PDOException $ex) {
        echo "Qualcosa nella STORE PROCEDURE inserisciCampo non è andato" .$ex->getMessage();
    }
?>
    </body>
</html>
