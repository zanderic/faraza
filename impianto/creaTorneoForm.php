<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
	
	$today = date("Y-m-d");
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Crea Torneo</title>
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
    <!-- immagine scorrimento per bootstrap -->
</head>
<body>
    <nav class="navbar navbar-default">
	<div class="container-fluid">
		<a class="navbar-brand" href="../impianto/homeImpiantoSportivo.php"><?php echo $_SESSION["Nome_centro"] ?></a>
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
					<a href="../impianto/homeImpiantoSportivo.php">Home</a>
		        </li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prenotazioni e Campi<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="../impianto/campo.php">Visualizza campi</a></li>
						<li><a href="../impianto/prenotazioniPartiteSingole.php">Prenotazioni Utente/Privata</a></li>
					</ul>
				</li>
				<li class="dropdown active">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tornei<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
                        <li><a href="../impianto/creaTorneoForm.php">Crea Tornei </a></li>
                        <li><a href="../impianto/visualizzaTornei.php">Visualizza Tornei</a></li>
                        <li class="divider"></li>
                        <li><a href="../torneo/creazioneTornei.php">Processa tornei</a></li>
		            </ul>
				</li>
				<li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pagelle<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
                        <li><a href="../impianto/pagellePartiteUtente.php">Pagelle Utente</a></li>
                        <li><a href="../impianto/pagellePartiteTorneo.php">Pagelle Torneo</a></li>
					</ul>
				</li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
			    <li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Opzioni<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
                        <li><a href="../impianto/visualizzaInfo.php">Visualizza Informazioni</a></li>
                        <li><a href="../impianto/updatefoto.php">Aggiorna foto</a></li>
						<li class="divider"></li>
                        <li><a href="../impianto/cancellaDaPiattaformaForm.php">Cancellati da Faraza</a></li>
					</ul>
				</li>
			    <li><a href="../logout.php">Logout</a></li>
		    </ul>
		</div>
	</div>
</nav>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Crea Torneo</h3>
			</div>
			<div class="panel-body">
				<form role="form" action="creaTorneo.php"  method="post"> 
					<div class="form-group"> 
						<label for="text">Nome</label>
						<input type="text" id="text" name="Nome" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="tipo">Tipo</label>
						<select id='tipo' name="Tipo" class="form-control">
							<option value='5' selected>5</option>
							<option value='7'>7</option>
						</select>
					</div>
					<div class="form-group"> 
						<label for="number">Costo</label>
						<div class="input-group">
							<input type="number" name="Costo" class="form-control" id='number' placeholder="Quota di partecipazione per ogni squadra" required>
							<div class="input-group-addon">€</div>
						</div>
					</div>
					<div class="form-group"> 
						<label for="inizio">Inizio Torneo</label>
						<input type="date" id='inizio' name="InizioTorneo" class="form-control" min="<?php echo $today; ?>" required>
					</div>
					<div class="form-group"> 
						<label for="fine">Fine Torneo</label>
						<input type="date" id='fine' name="FineTorneo" class="form-control" min="<?php echo $today; ?>" required>
					</div>
					<div class="form-group">
						<label for="iniziois">Inizio Iscrizioni</label>
						<input type="date" id='iniziois' name="InizioIscrizioni" class="form-control" min="<?php echo $today; ?>" required>
					</div>
					<p class="help-block"><strong>NOTA: </strong> Di default la fine delle iscrizioni è settata a due giorni prima dell'inizio del torneo.
					Per cambiare la data relativa alla fine delle iscrizioni, andare sulla pagina "Visualizza Tornei"</p>
					<div class="form-group"> 
						<label for="num">Numero minimo squadre</label>
						<input type="number" id='num' name="NumeroMinimoSquadre" class="form-control" min='3' required>
					</div>
					<button type="submit" class="btn btn-success btn-block">Crea</button>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
