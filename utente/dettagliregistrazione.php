<!-- 
@author Rappini Alessandro
In questo file vengono visualizzati tutti i dati della partita chiusa a qui un utente viene inviato
-->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();
    
    // Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
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
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="homeutente.php"><?php echo $nome.' '.$cognome ?></a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
			        <li class="active">
			        	<a href="homeutente.php">Home</a>
			        </li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Partite<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../partita/creaMatch.php">Crea una partita</a></li>
							<li><a href="../partita/cercaMatch.php">Cerca una partita</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tornei<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
			            	<li><a href="../torneo/creasquadra.php">Crea una squadra</a></li>
							<li><a href="../torneo/iscrivitisquadrapubblica.php">Iscriviti ad una squadra</a></li>
			            </ul>
					</li>
					<li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Commenti<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../utente/pagellautente.php">Commenta una Partita Utente</a></li>
							<li><a href="../utente/pagellautentetorneo.php">Commenta una Partita Torneo</a></li>
						</ul>
					</li>
					<li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recensioni<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../utente/recensioneimpianto.php">Recensione Centro Sportivo</a></li>
							<li><a href="../utente/visualizzarecensioni.php">Gestisci recensioni</a></li>
						</ul>
					</li>
					<li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cerca<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../utente/visualizzaprofilo.php">Utente</a></li>
							<li><a href="../utente/visualizzaprofilocentro.php">Centro Sportivo</a></li>
						</ul>
					</li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
				    <li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Opzioni<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../utente/visualizzainformazioni.php">Aggiorna profilo</a></li>
							<li><a href="../utente/caricaimmagine.php">Aggiorna foto</a></li>
							<li class="divider"></li>
							<li><a href="../utente/eliminaprofilo.php">Cancellati da Faraza</a></li>
						</ul>
					</li>
				    <li><a href="../logout.php">Logout</a></li>
			    </ul>
			</div>
		</div>
	</nav>
<?php
	try {
		// Estraggo email e password
		if ($_SESSION["case"] == "a") {
	        // Nel caso in qui l'utente sia loggato con i COOKIE
	        $email = $_COOKIE["email"];
	        $password = $_COOKIE["passw"];
	    } else {
	        // Nel caso in qui l'utente sia loggato tramite FORM
	        $email = $_POST["mail"];
	        $password = $_POST["password"];
	    }
		if ($_SESSION['tipo'] == 'creazionePartita' || $_SESSION['tipo'] == 'ricercaPartita') {
			$sql = "SELECT * FROM faraza.utente WHERE email = '$email' AND password = '$password'";
			$result = $_GLOBAL['pdo']->query($sql);
			$row = $result->fetch();
			// SESSION ID utente che sta per essere iscritto alla partita
			if ($row['ID']) {
				$_SESSION['ID'] = $row['ID'];
				echo '<script type="text/javascript">
					window.location.assign("../partita/dettagliMatch.php");
					</script>';
			} else {
				echo "<div class='alert alert-success' role='alert' align='middle'>Attenzione, credenziali errate.<br>Clicca nuovamente sul link della mail ricevuta per riprovare.</div>";
			}
	    } else if ($_SESSION['tipo'] == 'squadraTorneo') {
	        // Ricerca dell'ID dell'utente che ha ricevuto l'invito
	        $sql = "SELECT ID FROM faraza.utente WHERE email = '$email' AND password = '$password'";
	        $res = $_GLOBAL['pdo']->query($sql);
	        
	        $result_utente_invitato = $res->fetch();
			$IDinvitato = $result_utente_invitato["ID"]; // ID utente che ha ricevuto l'invito
			if ($IDinvitato) {
	            // Query che mi restituisce i dati della partita
	            $sql =  "SELECT squadra.nome as nomeSquadra , torneo.nome as nomeTorneo , torneo.inizioTorneo , torneo.fineTorneo , torneo.inizioIscrizioni , torneo.fineIscrizioni
						FROM faraza.squadra , faraza.partecipa , faraza.torneo
						WHERE squadra.ID=partecipa.IDSquadra AND partecipa.nomeTorneo=torneo.nome AND squadra.ID='".$_SESSION["IDsquadra"]."' ";
				$res = $_GLOBAL['pdo']->query($sql);
				$result_squadra = $res->fetch();
				
				$sql = "SELECT * FROM faraza.utente WHERE ID = '".$_SESSION['IDcreante']."'";
				$res = $_GLOBAL['pdo']->query($sql);
				$result_utente = $res->fetch();
	            
	            // Stampa i dettagli della partita
	            echo "L'utente " .$result_utente['nome'] . "  " .$result_utente['cognome'].""; 
	            echo "<br>";
	            echo " ti ha invitato a partecipare alla sua squadra chiamata: " .$result_squadra['nomeSquadra'];
	            echo "<br>";
	            echo " che partecipa al torneo  " .$result_squadra['nomeTorneo'];
	            echo "<br>";
	            echo "inizia " .$result_squadra['inizioTorneo'] . " e finisce " .$result_squadra['fineTorneo'];
	            echo "<br>";
	            echo "Se ti interessa partecipare clicca su registrati!";
	        } else {
				// Credenziali errate
				echo "<div class='alert alert-success' role='alert' align='middle'>Attenzione, credenziali errate.<br>Clicca nuovamente sul link della mail ricevuta per riprovare. 
					<br><br><a class='btn btn-success' role='button'>OK</a>	
					</div>";
			}
			// Traccia l'ID dell'utente invitato
			$_SESSION['IDR'] = $IDinvitato;
			
			echo "<a href='inserisciutenteinvitato.php'><button class='btn btn-default'>Iscriviti</button></a>";
			echo "<a href='../index.php'><button class='btn btn-default'>Abbandona</button></a>";
	    }
    } catch (PDOException $ex) {
        echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex -> getMessage();
        exit();
	}
?>
    </body>
</html>
