<?php
	// Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
	
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
	
	$_SESSION['tipo'] = ''; 
        if(isset($_POST['tipo_partita']))
        {
            $_SESSION['tipo'] = $_POST['tipo_partita'];
        }
        
	$_SESSION['giocatori'] = '';
    if(isset($_POST['num_giocatori'])) {
            $_SESSION['giocatori'] = $_POST['num_giocatori'];
	}
	$_SESSION['partita_utente'] = '';
	if(isset($_POST['tipo_partita_utente']))
        {
        $_SESSION['partita_utente'] = $_POST['tipo_partita_utente'];
    }
?>
<!DOCTYPE html>
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
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Impianti disponibili</h3>
				</div>
<?php
	try {
		// Selezione impianti registrati
		$sql = "SELECT * FROM faraza.impiantosportivo";
		$result = $_GLOBAL['pdo']->query($sql);
		
		// Costruzione tabella per visualizzare i centri sportivi
		echo "<table class='table table-hover'>
		<thead>
		<tr>
		<th>Nome Impianto</th>
		<th>Città</th>
		<th>Via</th>
		<th>Civico</th>
		<th>CAP</th>
		<th>Telefono</th>
		<th>Costo Orario</th>
		</tr>
		</thead>
		<tbody>";
		while ($row = $result->fetch()) {
			echo "<tr>";
			echo "<td>" . $row["nomeCentro"] . "</td>";
			echo "<td>" . $row["citta"] . "</td>";
			echo "<td>" . $row["via"] . "</td>";
			echo "<td>" . $row["civico"] . "</td>";
			echo "<td>" . $row["cap"] . "</td>";
			echo "<td>" . $row["telefono"] . "</td>";
			echo "<td>" . $row["costoOrario"] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
?>		
				<div class='panel-body'>
					<p><b>Scegli l'impianto in cui vuoi giocare per cercare i campi disponibili</b></p>
					<form method='POST' class="form-inline">
						<select name='id_impianto' class='form-control' required>
<?php		
		// Riempimento dinamico del menu' a tendina riguardo form scelta campo sportivo
    	$sql = "SELECT ID, nomeCentro FROM faraza.impiantoSportivo";
    	$result = $_GLOBAL['pdo']->query($sql);
		while ($row = $result->fetch()) {
			echo '<option value = "' . $row["ID"] . '" >' . $row["nomeCentro"] . '</option>';
		}

		echo "</select>";
		// Invio nuovamente le SESSION affinchè non vengano perse nell'inviare il primo form alla stessa pagina 
		echo '<input type="hidden" class="form-control" name="tipo_partita" value="' . $_SESSION['tipo'] . '"></input>';
		echo '<input type="hidden" class="form-control" name="num_giocatori" value="' . $_SESSION['giocatori'] . '"></input>';
		echo '<input type="hidden" class="form-control" name="tipo_partita_utente" value="' . $_SESSION['partita_utente'] . '"></input>';
?>
						<button type='submit' class="btn btn-success">Cerca campi</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
		$_SESSION['impianto'] = '';
        if(isset($_POST['id_impianto'])) {
            $_SESSION['impianto'] = $_POST['id_impianto']; // SESSION impianto
        }
		$num_impianto = $_SESSION['impianto'];
		
		// Recupero nome dell'impianto selezionato per la tabella		
		$sql = "SELECT nomeCentro FROM faraza.impiantoSportivo WHERE ID = '$num_impianto'";
		$result = $_GLOBAL['pdo']->query($sql);
		$row = $result->fetch();
		$titolo = $row['nomeCentro'];
?>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $titolo ?></h3>
				</div>
<?php
		$sql = "SELECT * FROM faraza.campo WHERE IDImpiantoSportivo = '$num_impianto'";
		$result = $_GLOBAL['pdo']->query($sql);
		$num = $result->rowCount() + 1;
		// Ricerca dei campi associato all'impianto appena scelto
		echo "<table class='table table-hover'>
		<thead>
		<tr>
		<th>Numero Campo</th>
		</tr>
		</thead>
		<tbody>";
		while ($row = $result->fetch()) {
			echo "<tr>";
			echo "<td>" . $row["ID"] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>
			</table>";
?>
				<div class='panel-body'>
					<p><b>Scegli il campo in cui vuoi giocare</b></p>
					<form action='datetime.php' method='POST' class="form-inline">
						<select name='id_campo' class="form-control" required>
<?php		
    	$sql = "SELECT ID FROM faraza.campo WHERE IDImpiantoSportivo = '$num_impianto'";
    	$result = $_GLOBAL['pdo']->query($sql);
		while ($row = $result->fetch()) {
			echo '<option value = "' . $row["ID"] . '" > Campo numero ' . $row["ID"] . '</option>';
		}
	} catch (PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
	}
?>
						</select>
<?php
						// Invio nuovamente le SESSION affinchè non vengano perse nell'inviare il primo form alla stessa pagina 
						echo '<input type="hidden" class="form-control" name="tipo_partita" value="' . $_SESSION['tipo'] . '"></input>';
						echo '<input type="hidden" class="form-control" name="num_giocatori" value="' . $_SESSION['giocatori'] . '"></input>';
						echo '<input type="hidden" class="form-control" name="tipo_partita_utente" value="' . $_SESSION['partita_utente'] . '"></input>';
?>
						<button type='submit' class="btn btn-success">Avanti</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>