<?php
	ob_start();
    session_start();
    include_once ("connessioneDB.php");
    global $_GLOBAL;        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Faraza - Benvenuto</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		
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
        $_SESSION["mail"] = $_POST["email_l"];
        $_SESSION["pass"] = $_POST["passw_l"];
        setcookie("email", $_POST["email_l"], time() + (86400 * 30), "/");
		setcookie("passw", $_POST["passw_l"], time() + (86400 * 30), "/");
        
        // Controllo dell'appartenenza delle credenziali, se Utente o Centro Sportivo
        try {
	        $sqlU = 'SELECT ID, nome, cognome FROM faraza.utente WHERE email= "'.$_SESSION["mail"].'" AND password= "'.$_SESSION["pass"].'"';
	        $resU=$_GLOBAL['pdo']->query($sqlU);
	        
            $sqlC = 'SELECT ID, nomeCentro FROM faraza.impiantosportivo WHERE email= "'.$_SESSION["mail"].'" AND password= "'.$_SESSION["pass"].'"';
            $resC=$_GLOBAL['pdo']->query($sqlC);
        } catch (PDOException $ex) {
            echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
            exit();
        }
        
        // Stampa del risultato
        $risultatoU = $resU->fetch();
        $risultatoC = $resC->fetch();
        if($risultatoU["nome"]) {
            $_SESSION["nome"] = $risultatoU["nome"];
            $_SESSION["cognome"] = $risultatoU["cognome"];
            $_SESSION['ID'] = $risultatoU["ID"];
            
            header("location:./utente/homeutente.php");
        } else if($risultatoC["nomeCentro"]) {
            $_SESSION["ID_Centro"] = $risultatoC["ID"];
            $_SESSION["Nome_centro"] = $risultatoC["nomeCentro"];
            header("location:./impianto/homeImpiantoSportivo.php");
        } else {           
            echo "<div class='alert alert-danger' role='alert' align='middle'><strong>Accesso negato!</strong><br>Il suo account non è ancora registrato oppure i dati da lei inseriti non sono corretti.
            	<br><br><a class='btn btn-danger' href='index.php' role='button'>Indietro</a>
            	</div>";
        }
?>
    </body>
</html>
