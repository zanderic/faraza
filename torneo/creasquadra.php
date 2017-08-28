<?php
	// Alessandro Rappini
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
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Tornei disponibili</h3>
				</div>
				<div class='panel-body'>
<?php
            $CDate = date('Y-m-d');
            try             
            {
                $sql = "SELECT * FROM faraza.torneo, faraza.impiantoSportivo WHERE torneo.IDImpiantoSportivo = impiantoSportivo.ID AND inizioIscrizioni <= CURDATE() AND fineIscrizioni >= CURDATE()";
                $result = $_GLOBAL['pdo']->query($sql);
            } catch (Exception $ex) {
                echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
                exit();
            }
            
            echo "<table class='table table-hover'>
            	<tr>
            	<th>Nome Torneo</th>
            	<th>Impianto</th>
            	<th>Costo</th>
            	<th>Inizio Torneo</th>
            	<th>Fine Torneo</th>
            	<th>Inizio Iscizioni</th>
            	<th>Fine Iscrizioni</th>
            	</tr>
            	<tbody>";
            $cont = 0;
            while ($row = $result->fetch()) {
                // Print out the contents of each row into a table
                echo "<tr><td>";
                echo $row['nome'];
                echo "</td><td>";
                echo $row['nomeCentro'];
                echo "</td><td>";
                echo $row['costo'];
                echo "</td><td>";
                echo $row['inizioTorneo'];
                echo "</td><td>";
                echo $row['fineTorneo'];
                echo "</td><td>";
                echo $row['inizioIscrizioni'];
                echo "</td><td>";
                echo $row['fineIscrizioni'];
                echo "</td></tr>";
            }
            echo "</tbody>
            	</table>";
?>
				</div>
			</div>
		</div>
    </div>
    <div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Caratteristiche squadra</h3>
				</div>
				<div class='panel-body'>
					<form action='creasquadrapost.php' method='POST'>
						<div class="form-group">
							<input class="form-control" type='text' name='nome' placeholder="Nome squadra" required>
						</div>
						<p><b>Tipologia squadra</b></p> 
						<select id='tipo' name='tipo' class='form-control'>
							<option value='pubblica' selected>pubblica</option>
							<option value='privata'>privata</option>
						</select><br>
						<p><b>Scelta torneo</b></p>
            
						<select class='form-control' name='nometorneo' required>
<?php
	            $result = $_GLOBAL['pdo']->query($sql);
	            while ($row = $result->fetch()) {
	                echo '<option value = "' . $row["nome"] . '" >' . $row["nome"] . '</option>';
	            }     
?>
			            </select><br>
						<button type="submit" class="btn btn-block btn-success">Avanti</button>
					</form>
				</div>
			</div>
		</div>
    </div>
</body>
</head>