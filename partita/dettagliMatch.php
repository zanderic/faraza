<?php
	// Riccardo Zandegiacomo
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
			<a class="navbar-brand" href="../utente/homeutente.php"><?php echo $nome.' '.$cognome ?></a>
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
			        <li>
			        	<a href="../utente/homeutente.php">Home</a>
			        </li>
					<li class="dropdown active">
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
		/* Estrazione informazioni riguardanti la partita selezionata, tracciata tramite $id
			La Session distingue il caso in cui ho appena creato la partita dal caso in cui la sto cercando
		*/ 
		if ($_SESSION['previousLocation'] == 'creazionePartita') {
			$id = $_SESSION['prenotazione']; // IDPrenotazione della prenotazione appena creata
		} else if ($_SESSION['previousLocation'] == 'ricercaPartita') {
			$id = $_POST['select']; // IDPrenotazione di partitaUtente
			$_SESSION['prenotazione'] = $id;
		// Utente che viene invitato ad una partota Utente Chiusa da link in email e che ha i COOKIE settati
		} else if ($_SESSION['tipo'] == 'creazionePartita' || $_SESSION['tipo'] == 'ricercaPartita') { 
			$id = $_SESSION["prenotazione"];
		}
		
		$sql = "SELECT numeroGiocatori, costo, risultato, luogo, campo, data, oraInizio, citta, via, civico, cap, telefono FROM faraza.partiteDisponibili WHERE ID='$id'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$giocatori = $row['numeroGiocatori'];
		$costo = $row['costo'];
		$risultato = $row['risultato'];
		$luogo = $row['luogo'];
		$campo = $row['campo'];
		$row_data = $row['data'];
		$data = date('Y-m-d', strtotime($row_data));
		$raw_ora = $row['oraInizio'];
		$ora = date('H:i', strtotime($raw_ora));
		$citta = $row['citta'];
		$via = $row['via'];
		$civico = $row['civico'];
		$cap = $row['cap'];
		$telefono = $row['telefono'];
		$today = date('Y-m-d');
		$now = date('H:i');
		$fine = date("H:i", strtotime('+1 hours', strtotime(date("H:i", strtotime($ora)))));
		$iscritto = 0; // Valore che segnala se un utente e' iscritto alla partita oppure no
		$creante = 0; // Valore che segnala se l'utente di sessione è l'utente creante
		
		// Cerco l'ID della partitaUtente a partire dall'IDPrenotazione
		$sql = "SELECT ID FROM faraza.partitaUtente WHERE IDPrenotazione = '$id'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$idMatch = $row[0];
		$_SESSION['match'] = $idMatch; // SESSION ID partitaUtente
		
		// Calcolo posti liberi della partita
		$sql = "SELECT COUNT(IDPartite) AS num FROM faraza.iscrizione WHERE IDPartite='$idMatch'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$_SESSION['liberi'] = ($giocatori*2)-$row[0];
		
		// Controllo se l'utente corrente e' gia' iscritto al match
		$sql = "SELECT COUNT(IDUtente) AS iscritto FROM faraza.iscrizione WHERE IDUtente='".$_SESSION['ID']."' && IDPartite='$idMatch'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$message1 = '';
		if ($row[0] != 0) {
			$message1 = 'SEI GIÀ ISCRITTO A QUESTA PARTITA!';
			$iscritto = 1; // Segnalato iscrtto
		}
		
		// Controllo se l'utente di sessione e' l'utente creante
		$sql = "SELECT COUNT(ID) AS creante FROM faraza.partitaUtente WHERE IDUtenteCreante='".$_SESSION['ID']."' && ID='$idMatch'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		if ($row[0] != 0) {
			$message2 = 'Sei il creatore di questa partita, vuoi aggiornare il punteggio?';
			$message3 = 'Inserisci il punteggio nello stesso formato in cui lo trovi scritto, per esempio 2-1';
			$creante = 1; // Segnalato creante
		}
		
		// Cerco componenti squadra A
		$sql = "SELECT COUNT(IDUtente) AS squadraA FROM faraza.iscrizione WHERE squadra='a' && IDPartite='$idMatch'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$sqA = $row[0];
		// Cerco componenti squadra B
		$sql = "SELECT COUNT(IDUtente) AS squadraB FROM faraza.iscrizione WHERE squadra='b' && IDPartite='$idMatch'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$sqB = $row[0];


	} catch (PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Punteggio <?php echo $risultato ?></h3>
				</div>
				<div class='panel-body'>
<?php
	if ($creante == 1 && $today > $data) {
		echo "<p style='color: #d51111'>$message2<br><i style='color: black'>$message3</i></p>";
		echo "<form action='score.php' method='POST'>
					<input class='form-control' type='text' name='score' placeholder='$risultato'></input><br>
					<button type='submit' class='btn btn-block btn-success'>Aggiorna</button>
				</form>";
	// Se la data è quella di oggi c'è da controllare anche che l'ora attuale sia successiva all'ora di fine partita
	} else if ($creante == 1 && $today == $data && $now > $fine) {
		echo "<p style='color: #d51111'>$message2<br><i style='color: black'>$message3</i></p>";
		echo "<form action='score.php' method='POST'>
					<input class='form-control' type='text', name='score', placeholder='$risultato'></input><br>
					<button type='submit' class='btn btn-block btn-success'>Aggiorna</button>
				</form>";
	}
?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Informazioni</h3>
				</div>
				<div class="panel-body">
					<!-- Costruzione tabella per visualizzare i centri sportivi -->
					<table class="table table-hover">
						<tbody>
							<tr>
							<th>Tipo</th>
							<td>Calcio a <?php echo $giocatori ?></td>
							</tr>
							<tr>
							<th>Centro Sportivo</th>
							<td><?php echo $luogo ?></td>
							</tr>
							<tr>
							<th>Campo</th>
							<td><?php echo $campo ?></td>
							</tr>
							<tr>
							<th>Data</th>
							<td><?php echo $data ?></td>
							</tr>
							<tr>
							<th>Ora</th>
							<td><?php echo $ora ?></td>
							</tr>
							<tr>
							<th>Città</th>
							<td><?php echo $citta ?></td>
							</tr>
							<tr>
							<th>Via</th>
							<td><?php echo $via ?></td>
							</tr>
							<tr>
							<th>Civico</th>
							<td><?php echo $civico ?></td>
							</tr>
							<tr>
							<th>CAP</th>
							<td><?php echo $cap ?></td>
							</tr>
							<tr>
							<th>Telefono</th>
							<td><?php echo $telefono ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Posti disponibili: <?php echo $_SESSION['liberi'] ?></h3>
				</div>
				<div class='panel-body'>
					<table class='table table-bordered'>
						<p style="color: #d51111"><?php echo $message1 ?></p>
<!-- Lista dei giocatori -->
<?php
	
	echo "<thead>
		<tr>
		<th>Bianchi</th>
		<th>Neri</th>
		</tr>
		</thead>
		<tbody>
		<tr>";
		if ($sqA > 0) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 0) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
	echo "</tr>
		<tr>";
		if ($sqA > 1) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 1) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
	echo "</tr>
		<tr>";
		if ($sqA > 2) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 2) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
	echo "</tr>
		<tr>";
		if ($sqA > 3) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 3) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
	echo "</tr>
		<tr>";
		if ($sqA > 4) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 4) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
	echo "</tr>";
	if ($giocatori == '7') {
		echo "<tr>";
		if ($sqA > 5) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 5) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		echo "</tr>
			<tr>";
		if ($sqA > 6) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		if ($sqB > 6) {
			echo "<td bgColor='green'>&nbsp</td>";
		} else {
			echo "<td>&nbsp</td>";
		}
		echo "</tr>";
	}
	echo "</tbody>
		</table>";
	if ($iscritto == 0 && $_SESSION['liberi'] > 0) {
		echo "<p>In che squadra vuoi giocare?</p>
			<form action='iscrizione.php' method='POST'>
				<select class='form-control' name='squadra'>
					<option value='a'>Bianchi</option>
					<option value='b'>Neri</option>
				</select><br>
				<button type='submit' class='btn btn-block btn-success'>Iscriviti</button>
			</form>";
	}
	// Controllo per inviare mail SOLO se la partita è una partita Privata a cui si è iscritto
    try {
        $sqlButton = "SELECT pu.ID as i, p.dataPrenotazione as p
                    FROM faraza.partitaUtente as pu, faraza.prenotazione as p 
                    WHERE p.ID = pu.IDPrenotazione AND pu.tipo = 'partitaChiusa' AND pu.ID = '".$_SESSION['match']."' ";
        $resButton = $_GLOBAL['pdo']->query($sqlButton);
    } catch (PDOException $ex) {
        echo 'Verifica partitaPrivata' .$ex->getMessage();
    }
    $rowButton = $resButton->fetch();
    // Se esiste un id alle condizione espresse dalla select allora mi stampa il bottone invita
    if ($rowButton['i'] != NULL && $today<$rowButton['p']) { // vuol dire che la partitaUtente è chiusa, quindi devo poter invitare altri utenti
       echo '<form action="../utente/sendemailinvito.php" method=POST>';
       echo '<button type="submit" class="btn btn-block btn-success">Invita amico</button>';
       echo '</form>';
    }
    
    if ($today < $data && $iscritto == 1) {
	    echo '<form action="../utente/eliminaIscrizione.php" method=POST>';
		echo '<button type="submit" class="btn btn-block btn-success">Cancellati dalla partita</button>';
		echo '</form>';
    }
?>
	</body>
</html>
	