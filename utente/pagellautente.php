<?php
	// Alessandro Rappini
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
		
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faraza - Commenti</title>
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
					<li class="dropdown active">
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
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Partite Utente</h3>
				</div>
				<div class='panel-body'>
<?php
            $CDate = date('Y-m-d');
            try {
                $sql = "SELECT pu.ID, p.dataPrenotazione, i.NomeCentro, pu.punteggio
                        FROM faraza.partitaUtente as pu, faraza.prenotazione as p, faraza.impiantosportivo as i
                        WHERE pu.IDPrenotazione = p.ID AND p.IDCentroSportivo = i.ID AND p.dataPrenotazione  >= $CDate
                        ORDER BY p.dataPrenotazione";
                $res=$_GLOBAL['pdo']->query($sql);
            } catch (Exception $ex) {
                echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
                exit();
            }
            echo "<table class='table table-hover'>
            	<thead>
            	<tr>
            	<th>#</th>
            	<th>Data</th>
            	<th>Nome Centro</th>
            	<th>Punteggio</th>
            	</tr>
            	</thead>
            	<tbody>";
			$count = 1;
			$finale = 1;
            while ($row = $res->fetch()) {
                echo "<tr><td>";
                echo $count;
                echo "</td><td>";
                echo $row[1];
                echo "</td><td>";
                echo $row[2];
                echo "</td><td>";
                echo $row[3];
                echo "</td></tr>";
                $count++;
                $finale = $count;
            }
            echo "</tbody>
            	</table>";
?>
			    <p><b>Inserisci il numero della partita dove vuoi recensire un giocatore:</b></p>
			    <form action='pagellautenteget.php' method='POST'>
			        <select name='partita' class='form-control' required>
<?php       
	        $result = $_GLOBAL['pdo']->query($sql);
	        $count = 1;
	        while ($row = $result->fetch()) {
	            echo '<option value = "' . $row["ID"] . '" >'.$count.'</option>';
	            $count++;
	        }     
?>
        				</select><br>
						<button type='submit' class='btn btn-block btn-success'>Avanti</button>
					</from>
				</div>
			</div>
		</div>
    </div>
</body>
</html>		