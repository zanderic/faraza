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
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Partite<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../partita/creaMatch.php">Crea una partita</a></li>
							<li><a href="../partita/cercaMatch.php">Cerca una partita</a></li>
						</ul>
					</li>
					<li class="dropdown active">
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
	$_SESSION['classificaMarcatori'] = $_GET['marcatori'];
	try {
		$sqlMarcatori = 'SELECT g.goalFatti as goal, u.nome as n, u.cognome as c, s.nome as squad, u.ID as d
						FROM faraza.squadra as s, faraza.partecipa as p, faraza.torneo as t, faraza.giocatore as g, faraza.utente as u
						WHERE u.ID = g.IDGiocatore AND g.IDSquadra= s.ID AND t.nome = "'.$_SESSION["classificaMarcatori"].'" AND s.ID = p.IDSquadra AND p.nomeTorneo = t.nome 
						ORDER BY g.goalFatti DESC';
		$resMarcatori = $_GLOBAL['pdo'] -> query($sqlMarcatori);
	} catch (Exception $ex) {
		echo "Errore nella query: " . $ex -> getMessage();
		exit();
	}
?>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Classifica marcatori <?php echo $_SESSION['classificaMarcatori']; ?></h3>
				</div>
				<div class="panel-body">
				<table class="table table-hover">
					<thead>
					<tr>
					<th>Giocatore</th>
					<th>Goal Fatti</th>
					<th>Squadra</th>
					</tr>
					</thead>
					<tbody>
<?php
				while($rowMarcatori = $resMarcatori->fetch()) {
					echo '<tr>';
					$_SESSION['row_count_' . $rowMarcatori['d']] = $rowMarcatori['d'];
					echo '<td>  <a href=../utente/profiloUtente.php?num='.$_SESSION['row_count_'.$rowMarcatori['d']].' >'.$rowMarcatori['n'].' '.$rowMarcatori['c'].' </a>  </td>';	
					echo '<td> '.$rowMarcatori['goal'].' </td>';
					echo '<td> '.$rowMarcatori['squad'].' </td>';
					echo '</tr>';
				}
?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
