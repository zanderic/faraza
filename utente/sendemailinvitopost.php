<!-- @author Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    include_once ("../email.php");
    global $_GLOBAL;
    session_start();
 ?>
 <html>
	<head>
	    <title>Faraza - Utente</title>
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
    if ($_SESSION['previousLocation'] == 'creazionePartita' || $_SESSION['previousLocation'] == 'ricercaPartita') {
	    $message= "Ciao, ti ho invitato a partecipare ad un torneo con la mia squadra privata, clicca sul link per loggarti e conoscere tutti i dettegli!
               http://localhost/utente/confermaregistrazione.php?prenotazione=".$_SESSION['prenotazione']."&tipo=".$_SESSION['previousLocation']."";
    } else if ($_SESSION['previousLocation'] == 'squadraTorneo') {
		$message= "Ciao, ti ho invitato a partecipare ad una torneo con la mia squadra privata, clicca sul link per loggarti e conoscere tutti i dettegli!
               http://localhost/utente/confermaregistrazione.php?IDsquadra=" .$_SESSION["IDsquadra"]."&IDcreante=" . $_SESSION["ID"]."&tipo=".$_SESSION['previousLocation']."";
	}

    // Oggetto
    $subject = "FARAZA - Invito a partecipare ad un torneo da: " .$_SESSION["Nome"]. " " .$_SESSION["Cognome"]. "";
    // Invio tante mail quanti sono i giocatori della squadra
    $count = 0; // Tiene conto delle mail non andate a buon fine
    for ($x = 1; $x < $_SESSION["num_min"]; $x++) {
        $to = $_POST[$x];

        $sql = "SELECT ID FROM faraza.utente WHERE email = '$to'";
        $res = $_GLOBAL['pdo']->query($sql);
        $row = $res->fetch();
		
		
        if($row) {
			// Se la mail esiste e quindi l'utente è iscritto alla piattaforma invio la mail
			sendmail($to , $subject, $message);
			
			// Aggiorno campo visto ad 1
			$sql = "UPDATE faraza.utente SET visto = 1 WHERE email = '$to'";
			$proc = $_GLOBAL['pdo']->query($sql);
        } else {
			$count++;
        }
    }

    if ($_SESSION['previousLocation'] == 'squadraTorneo') {
		echo "<div class='alert alert-success' role='alert' align='middle'>Amici invitati!<br><br>ATTENZIONE: ".$count." amici non sono stati invitati con successo.
			<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>	
			</div>";
    } else if ($_SESSION['previousLocation'] == 'creazionePartita') {
		echo "<div class='alert alert-success' role='alert' align='middle'>Amici invitati!<br><br>ATTENZIONE: ".$count." amici non sono stati invitati con successo.
			<br><br><a class='btn btn-success' href='../partita/dettagliMatch.php' role='button'>OK</a>	
			</div>";
    } else {
		echo "<div class='alert alert-success' role='alert' align='middle'>Amici invitati!<br><br>ATTENZIONE: ".$count." amici non sono stati invitati con successo.
			<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
			</div>";
    }
?>