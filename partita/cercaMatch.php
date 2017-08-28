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
	$_SESSION['previousLocation'] = 'ricercaPartita'; // Session che traccia da che pagina arrivo
	try {
	    $sql = 'SELECT count(*) as t FROM faraza.partitaUtente';
	    $res = $_GLOBAL['pdo']->query($sql);
	    $row = $res->fetch();
	    
	    if($row['t'] == "0") {
	        echo "<div class='alert alert-success' role='alert' align='middle'>Al momento non ci sono partite disponibili
	    		<br><br><a class='btn btn-success' href='../utente/homeUtente.php' role='button'>OK</a>	
				</div>";
		} else {
?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Partite Utente in programma</h3>
				</div>
				<div class='panel-body'>
					<form action="dettagliMatch.php" method="POST">
<?php
			$week_ago = date("Y-m-d", strtotime('-7 days', strtotime(date('Y-m-d'))));
			$now = date('H:i');
			// Selezione partite disponibili nel futuro prossimo
			$sql = "SELECT ID, tipo, numeroGiocatori, luogo, data, oraInizio FROM faraza.partiteDisponibili WHERE data >= '$week_ago' ORDER BY data, oraInizio";
			$result = $_GLOBAL['pdo']->query($sql);
			$count = 1;
			
			// Costruzione tabella per visualizzare i centri sportivi
			echo "<table class = 'table table-hover'>
			<thead>
			<tr>
			<th width='20'>#</th>
			<th>Disponibilità</th>
			<th>Tipo Partita</th>
			<th>Luogo</th>
			<th>Data</th>
			<th>Ora</th>
			</tr>
			</thead>
			<tbody>";
			while ($row = $result->fetch()) {
				$iscrizionePartita = 1;	// Verifica se l'utente e' iscritto alla partita, di default e' false				
				echo "<tr>";
				echo "<td align='middle'>$count</td>";
				if ($row["tipo"] == 'partitaAperta') {
					echo "<td><img src='png/unlock.png' align='right' alt='Partita Aperta' /></td>";
				} else {
					echo "<td><img src='png/lock.png' alt='Partita Chiusa' /></td>";
					// Qui faccio controllo per vedere se sono iscritto alla partita:	                
                	$sqlPartitaPrivata = "SELECT IDUtente FROM faraza.iscrizione WHERE IDUtente = '".$_SESSION['ID']."' AND IDPartite = '".$row['IDpartita']."'";
					$resPartitaPrivata = $_GLOBAL['pdo']->query($sqlPartitaPrivata);
					$rowPartitaPrivata = $resPartitaPrivata->fetch();
					
	                // Se l'utente loggato e' iscritto alla partita Utente Chiusa che si sta analizzando
	                if($rowPartitaPrivata["IDUtente"] == $_SESSION['ID']) {
	                    $iscrizionePartita = 0;
	                }
				}
				echo "<td>Calcio a " . $row["numeroGiocatori"] . "</td>";
				echo "<td>" . $row["luogo"] . "</td>";
				echo "<td>" . date('d-m-Y', strtotime($row["data"])) . "</td>";
				echo "<td align='middle'>" . date('H:i', strtotime($row["oraInizio"])) . "</td>";
				if ($row["tipo"] == 'partitaAperta') {
					echo "<td align='middle'><input type='radio' name='select' value='" . $row["ID"] . "' required></td>";	// Valore passato, IDPrenotazione
				} else {
					if($iscrizionePartita == 1) {
	                	echo "<td align='middle'><input type='radio' name='select' value='" . $row["ID"] . "' disabled required></td>";
		            } else if($iscrizionePartita == 0) {
		                echo "<td align='middle'><input type='radio' name='select' value='" . $row["ID"] . "' required></td>";
					}			
				}
				echo "</tr>";
				$count ++;
			}
		}
	} catch(PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>
		</tbody>
		</table>
		<div class='panel-footer'>Il lucchetto aperto rappresenta una Partita Utente Aperta, quello chiuso una Partita Utente Chiusa.
			<br>Per accedere ai dettagli di una Partita Utente Chiusa devi essere iscritto ad essa.
		</div>
		<button type='submit' class="btn btn-block btn-success">Avanti</button>
	</form>
</body>
</html>