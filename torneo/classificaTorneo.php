<?php
	// Alessandro Rappini, Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
	
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<!DOCTYPE html>
<!--
Classifica Torneo lato utente
-->
<html>
    <head>
        <title>Faraza - Torneo</title>
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
    $_SESSION["Veditorneo"] = $_GET["torneoScelto"];   
    
    try {
        $sqlCountClassifica = 'SELECT count(*) AS c FROM faraza.squadra as s, faraza.partecipa as p, faraza.torneo as t
        						WHERE t.nome = "'.$_SESSION["Veditorneo"].'" AND s.ID = p.IDSquadra AND p.nomeTorneo = t.nome';
        $risCountClassifica = $_GLOBAL["pdo"]->query($sqlCountClassifica);
		$rowCountClassifica = $risCountClassifica->fetch();
        if($rowCountClassifica["c"] == 0) {
			echo "<div class='alert alert-danger' role='alert' align='middle'>La classifica al momento non è ancora disponibile, riprovare più tardi.
			<br><a class='btn btn-danger' href='../impianto/homeImpiantoSportivo.php' role='button'>OK</a>	
			</div>";
        } else {	
            $sqlClassificaTorneo = 'SELECT s.nome, s.tipo, s.punti, s.partiteVinte, s.partitePerse, s.partitePareggiate, s.goalFatti, s.goalSubiti
                        			FROM faraza.squadra as s, faraza.partecipa as p, faraza.torneo as t
									WHERE t.nome = "'.$_SESSION["Veditorneo"].'" AND s.ID = p.IDSquadra AND p.nomeTorneo = t.nome
									ORDER BY s.punti';
			$resClassificaTorneo = $_GLOBAL['pdo']->query($sqlClassificaTorneo);
?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 align="center" class="panel-title">Classifica <?php echo $_SESSION["Veditorneo"]; ?></h3>
						</div>
						<div class="panel-body">
				        <table class='table table-hover'>
							<thead>
							<tr>
							<th>Nome</th>
							<th>Tipo</th>
					        <th>Punti</th>
					        <th>Vinte</th>
					        <th>Perse</th>
					        <th>Pareggiate</th>
					        <th>GF</th>
					        <th>GS</th>
					        <th>DR</th>
					        </tr>
							</thead>
							<tbody>
<?php   
	        while($rowClassificaTorneo = $resClassificaTorneo->fetch()) {
	            echo '<tr>';
	            echo '<td> '.$rowClassificaTorneo['nome'].' </td>';
	            echo '<td> '.$rowClassificaTorneo['tipo'].' </td>';
	            echo '<td> '.$rowClassificaTorneo['punti'].' </td>';
	            echo '<td> '.$rowClassificaTorneo['partiteVinte'].' </td>';
	            echo '<td> '.$rowClassificaTorneo['partitePerse'].' </td>';
	            echo '<td> '.$rowClassificaTorneo['partitePareggiate'].' </td>';
	            $_SESSION['goal_fatti'] = $rowClassificaTorneo['goalFatti'];
	            echo '<td> '.$_SESSION['goal_fatti'].' </td>';
	            $_SESSION['goal_subiti'] = $rowClassificaTorneo['goalFatti'];
	            echo '<td> '.$_SESSION['goal_subiti'].' </td>';
	            echo '<td> '.($_SESSION['goal_fatti']-$_SESSION['goal_subiti']).' </td>';
	            echo '</tr>';
	        }
?>
							</tbody>        
						</table>
						</div>
					</div>
				</div>
			</div>
<?php
		}
    } catch (PDOException $ex) {
        echo 'Errore nella query: ' . $ex->getMessage();
    }
?>
    </body>
</html>
