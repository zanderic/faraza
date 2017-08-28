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
		<div class="col-md-offset-2 col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Giocatori</h3>
				</div>
				<div class="panel-body">
<?php
                $partita = $_POST["partita"];
                $_SESSION["npartita"] = $partita;
                try {
                    $sql = "SELECT utente.ID, utente.nome, utente.cognome
                            FROM faraza.utente , faraza.iscrizione , faraza.partitaUtente
                            WHERE utente.ID=iscrizione.IDUtente AND iscrizione.IDPartite=partitaUtente.ID AND partitaUtente.ID=$partita";
                    $res=$_GLOBAL['pdo']->query($sql);
                } catch (Exception $ex) {
                    echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
                    exit();
                }
               
                echo "<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Nome</th>
                	<th>Cognome</th>
                	</tr>
                	</thead>
                	<tbody>";
                while ($row = $res->fetch()) {
                    echo "<tr><td>";
                    echo $row[1];
                    echo "</td><td>";
                    echo $row[2];
                    echo "</td></tr>";
                }
                echo "</tbody>
                	</table>";
?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Valutazione</h3>
				</div>
				<div class="panel-body">
		        	<form action="pagellautenteins.php" method="GET">
			        	<label for="id">Scegli giocatore</label>
		            	<select class="form-control" name='id'>
<?php       
                    $sql = "SELECT utente.ID, utente.nome, utente.cognome
                            FROM faraza.utente, faraza.iscrizione, faraza.partitaUtente
                            WHERE utente.ID=iscrizione.IDUtente AND iscrizione.IDPartite=partitaUtente.ID AND partitaUtente.ID=$partita";
                    $result = $_GLOBAL['pdo']->query($sql);
                    while ($row = $result->fetch()) {
                        echo '<option value = "' . $row["ID"] . '" >' . $row["nome"] .' '. $row["cognome"] . '</option>';
                    }
?>
	            		</select><br>
		                <label for="voto">Voto</label>
		                <select class='form-control' id='voto' name='voto'>
					        <option name='1' value='1'>1</option>
					        <option name='2' value='2'>2</option>
					        <option name='3' value='3'>3</option>
					        <option name='4' value='4'>4</option>
					        <option name='5' value='5'>5</option>
						</select><br>
		                <label for="comm">Commento</label>
		                <textarea class="form-control" name="comm" id="comm" rows="3" required></textarea><br>
		                <button type='submit' class="btn btn-success btn-block">Commenta</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>		