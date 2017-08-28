<?php
	// Alessandro Rappini
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();

    $ID = $_SESSION["ID"];
    $num = $_POST["num"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faraza - Tornei</title>
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
    // Controllo se l'utente che si vuole iscrivere alla squadra non si sia gia' iscritto ad un'altra squadra nello stesso torneo
    try {
		$sql = "SELECT torneo.nome
			FROM giocatore, squadra, partecipa, torneo
			WHERE giocatore.IDSquadra = squadra.ID AND squadra.ID = partecipa.IDSquadra AND partecipa.nomeTorneo = torneo.nome  
			AND giocatore.IDGiocatore='$ID' AND torneo.nome='".$_SESSION["nomeTorneo"]."' ";
            $res = $_GLOBAL['pdo']->query($sql);
        
	    if($res->fetch()){
	        echo "<div class='alert alert-danger' role='alert' align='middle'>Sei gia' iscritto ad una squadra che partecipa allo stesso torneo.
			   		<br><br><a class='btn btn-danger' href='../utente/homeutente.php' role='button'>OK</a>
			   		</div>";
		} else {
            // Puoi iscriverti perchè non lo hai ancora fatto            
            $sql = "INSERT INTO faraza.giocatore (IDGiocatore, IDSquadra) VALUES ($ID, $num)"; // scrivo sul DB questi valori
            $res = $_GLOBAL['pdo']->query($sql);            
			echo "<div class='alert alert-success' role='alert' align='middle'>Iscrizione avvenuta con successo!
					br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
					</div>";
    	}
    } catch (Exception $ex) {
        echo "Errore, la query non e' andata a buon fine: " . $ex->getMessage();
        exit();
	}
?>
