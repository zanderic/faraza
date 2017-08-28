<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Impianto Sportivo</title>
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
    <!-- immagine scorrimento per bootstrap -->
</head>
<?php
	$_SESSION["Nome"] = $_POST["Nome"];
	$_SESSION["Tipo"] = $_POST["Tipo"];
	$_SESSION["Costo"] = $_POST["Costo"];
	$_SESSION["InizioTorneo"] = $_POST["InizioTorneo"];
	$_SESSION["FineTorneo"] = $_POST["FineTorneo"];
	$_SESSION["InizioIScrizioni"] = $_POST["InizioIscrizioni"];
	$fine = date("Y-m-d", strtotime('-2 days', strtotime($_SESSION["InizioIScrizioni"]))); // Cerco spazi nel giorno successivo
	$_SESSION["NumeroMinimoSquadre"] = $_POST["NumeroMinimoSquadre"];
	$dataOdierna = date("Y-m-d"); // ricavo la data odierna come punto di partenza per creare un torneo
	
	// controllo se c'è già un torneo con quel nome
	$stmt = $_GLOBAL['pdo']->prepare('CALL verificaNomeTorneo( ? ,@booleanName)'); // preparo la chimata alla store procedure
	$stmt->bindParam(1, $_SESSION['Nome'], $_GLOBAL['pdo']::PARAM_STR, 4000); // definisco i parametri;
	// call the stored procedure
	$stmt->execute();
	$result = $_GLOBAL['pdo']->query('SELECT @booleanName');
	$row = $result->fetch();
	$outputbooleanoNomeTorneo = $row['@booleanName'];
	// print the store procedure
	//print "procedure returned $outputbooleano\n <br><br>";
	if (($outputbooleanoNomeTorneo == TRUE)) {   
		echo "<div class='alert alert-danger' role='alert' align='middle'>Nome torneo già in uso, immettere un altro nome.
	    	<br><br><a class='btn btn-danger' href='../impianto/creaTorneoForm.php' role='button'>OK</a>	
	    	</div>";
	    exit();
	}
	// se la fine del torno viene settata per errore a prima dell'inizio..
	else if ($_SESSION["InizioTorneo"] > $_SESSION["FineTorneo"]) {
	    echo "<div class='alert alert-danger' role='alert' align='middle'>Attenzione alle date...
	    	<br><br><a class='btn btn-danger' href='../impianto/creaTorneoForm.php' role='button'>OK</a>	
	    	</div>";
	    exit();
	}
	else if($dataOdierna > $_SESSION["InizioTorneo"] )
	{
	    echo "<div class='alert alert-danger' role='alert' align='middle'>La data di inizio del torneo è già passata.
	    	<br><br><a class='btn btn-danger' href='../impianto/creaTorneoForm.php' role='button'>OK</a>	
	    	</div>";
	    exit();
	}
	else if($_SESSION["InizioIScrizioni"]>$_SESSION["InizioTorneo"] || $dataOdierna >= $_SESSION["InizioIScrizioni"]) 
	{    
	    echo "<div class='alert alert-danger' role='alert' align='middle'>Data di inizio iscrizioni già passata.
	    	<br><br><a class='btn btn-danger' href='../impianto/creaTorneoForm.php' role='button'>OK</a>	
	    	</div>";
	    exit();
	}
	
	try {
	    echo $sql = 'INSERT INTO faraza.torneo (nome, IDImpiantoSportivo, tipo, costo, inizioTorneo, fineTorneo, inizioIscrizioni, fineIscrizioni, numeroMinimoSquadre)
	    			VALUES("' . $_SESSION["Nome"] . '", "' . $_SESSION["ID_Centro"] . '", "' . $_SESSION["Tipo"] . '","' . $_SESSION["Costo"] . '","' . $_SESSION["InizioTorneo"] . '",
	    			"' . $_SESSION["FineTorneo"] . '","' . $_SESSION["InizioIScrizioni"] . '","'.$fine.'","' . $_SESSION["NumeroMinimoSquadre"] . '")';
	
	    $res = $_GLOBAL['pdo']->exec($sql);
	    echo "<div class='alert alert-success' role='alert' align='middle'>Il torneo <strong>".$_SESSION["Nome"]."</strong> e' stato creato con successo!
	    	<br>Per maggiori informazioni visita la pagina Visualizza Tornei Creati
	    	<br><br><a class='btn btn-success' href='../impianto/homeImpiantoSportivo.php' role='button'>OK</a>	
	    	</div>";
	} catch (PDOException $ex) {
	    echo("[ERRORE] Query SQL (Insert) non riuscita. Errore: " . $ex->getMessage());
	    exit();
	}
?>





