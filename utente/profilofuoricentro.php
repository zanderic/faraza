<?php
	// Alessandro Rappini, Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
		
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<html>
<head>
    <title>Faraza - Cerca</title>
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
	// Recupero Immagini del profilo
	try {
       $sqlImage = 'SELECT  Path1,Path2,Path3 FROM faraza.impiantoSportivo WHERE ID= "' .$id. '" ';

       $resPath = $_GLOBAL["pdo"]->query($sqlImage);
    } catch (PDOExceptionException $ex) {
       echo "Errore nella query: " .$ex->getMessage();
	}
	$risultatoPath = $resPath->fetch();
	if ($risultatoPath["Path1"]) {
		$_SESSION["Percorso1"] = $risultatoPath["Path1"];
	} else if($risultatoPath["Path1"]=="") {
		$_SESSION["Percorso1"] = "../foto/default.jpg";
	}
	
	if ($risultatoPath["Path2"]) {
		$_SESSION["Percorso2"] = $risultatoPath["Path2"];
	} else if($risultatoPath["Path2"]=="") {
		$_SESSION["Percorso2"] = "../foto/default.jpg";
	}
	
	if ($risultatoPath["Path3"]) {
		$_SESSION["Percorso3"] = $risultatoPath["Path3"];
	} else if($risultatoPath["Path3"]=="") {
		$_SESSION["Percorso3"] = "../foto/default.jpg";
	}
	// Recupero informazioni
    $ID = $_POST["num"];
    try {
		$sql = "SELECT * FROM faraza.impiantosportivo   WHERE  impiantosportivo.ID = '$ID' ";
		$res = $_GLOBAL['pdo']->query($sql);
    } catch (Exception $ex) {
		echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
		exit();
    }

    while ($row = $res ->fetch()) {
        $id = $row[0];
        $nome = $row[1];
        $_SESSION["mail_profiloFuori"] = $row[2];
        $costoOrario = $row[4];
        $citta = $row[5];
        $via = $row[6];
        $civico = $row[7];
        $cap = $row[8];
        $telefono = $row[9];
    }
?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title"><?php echo $nome; ?></h3>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<img src = <?php echo $_SESSION["Percorso1"]; ?> class = "img-responsive img-thumbnail" alt="Profile Pic">
						<img src = <?php echo $_SESSION["Percorso2"]; ?> class = "img-responsive img-thumbnail" alt="Profile Pic">
						<img src = <?php echo $_SESSION["Percorso3"]; ?> class = "img-responsive img-thumbnail" alt="Profile Pic">
					</div>
					<div class="col-md-6">
						<table class="table table-hover"
						<tbody>
							<tr>
							<th>Email</th>
							<td><?php echo $_SESSION["mail_profiloFuori"]; ?></td>
							</tr>
							<tr>
							<th>Telefono</th>
							<td><?php echo $telefono; ?></td>
							</tr>
							<tr>
							<th>Recapito</th>
							<td><?php echo 'Via '.$via.', '.$civico.' - '.$citta.', ' .$cap; ?></td>
							</tr>
							<tr>
							<th>Costo orario</th>
							<td><?php echo $costoOrario; ?></td>
							</tr>
						</tbody>
						</table
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Prenotazioni</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>Numero Campo</th>
							<th>Data</th>
							<th>Inizio</th>
							<th>Fine</th>
							<th>Tipo partita</th>
						</tr>
						</thead>
						<tbody>
<?php
			// Visualizzazione delle prenotazioni in generale da parte del torneo (di qualunque tipo di partita)
			try {
			    $sqlPrenotazioni = 'SELECT p.numCampo, p.dataPrenotazione, p.oraInizio, p.oraFine, p.tipoPartita FROM faraza.prenotazione as p WHERE IDCentroSportivo = "'.$id.'" ORDER BY p.dataPrenotazione';
			    $risPrenotazioni = $_GLOBAL["pdo"]->query($sqlPrenotazioni);
			} catch (PDOException $ex) {
				echo "La registrazioni totali" . $ex->getMessage();
			}
			while($rowPrenotazioni = $risPrenotazioni->fetch()) {
				echo "<tr>";
				$_SESSION["NumCampo"] = $rowPrenotazioni["numCampo"];
				echo '<td>'.$_SESSION["NumCampo"].'</td>';
				
				$_SESSION["data_prenotazione"] = $rowPrenotazioni["dataPrenotazione"];
				$correct_date = date('d-m-Y', strtotime($_SESSION["data_prenotazione"]));
				echo '<td>'.$correct_date.'</td>';
				
				$_SESSION["Ora_Inizio"] = $rowPrenotazioni["oraInizio"];
				$time = date('H:i', strtotime($_SESSION["Ora_Inizio"]));
				echo '<td>'.$time.'</td>';
				
				$_SESSION["Ora_Fine"] = $rowPrenotazioni["oraFine"];
				$time = date('H:i', strtotime($_SESSION["Ora_Fine"]));
				echo '<td>'.$time.'</td>';
				
				$_SESSION["Tipo_Partita"] = $rowPrenotazioni["tipoPartita"];
				echo '<td>'.$_SESSION["Tipo_Partita"].'</td>';
			}
?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Commenti</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>Nome Utente</th>
							<th>Data</th>
							<th>Voto</th>
							<th>Commento</th>
						</tr>
						</thead>
						<tbody>
<?php
		// Visualizzazione dei commenti ricevuti
		try {
		    // Query sulla view vediCommenti (vogliamo l'ID dell'ImpiantoSportivo loggato)
		    $sqlComment = 'SELECT nome, cognome, data, voto, commento
		                   FROM vediCommenti
		                   WHERE IDCentro = "'.$id.'"';
		    $resultComment = $_GLOBAL["pdo"]->query($sqlComment);
		    
		} catch (Exception $ex) {
		    echo "Qualcosa non è andato nella chiamata alla view " .$ex->getMessage();
		}
		 
		while($rowComment = $resultComment->fetch())
		{
			echo "<tr>";
			$_SESSION["utdn"] = $rowComment["nome"];
			$_SESSION["utdc"] = $rowComment["cognome"];
			echo '<td>'.$_SESSION["utdn"].' '.$_SESSION["utdc"].'</td>'; 
			
			$_SESSION["date"] = $rowComment["data"];
			$correct_date = date('d-m-Y', strtotime($_SESSION["date"]));
			echo '<td>'.$correct_date.'</td>'; 
			
			$_SESSION["result"] = $rowComment["voto"];
			echo '<td>'.$_SESSION["result"].'</td>'; 
			
			
			$_SESSION["comment"] =$rowComment["commento"];
			echo '<td>'.$_SESSION["comment"].'</td>';
			echo "</tr>";
		}
?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Contatta il centro</h3>
				</div>
				<div class="panel-body">				
					<form action="sendEmail.php" method="POST">
						<label for="textarea"></label>
						<textarea class='form-control' name="textmail" id="textarea" rows="5"></textarea><br>
						<button type='submit' class='btn btn-block btn-success'>Scrivi</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>		