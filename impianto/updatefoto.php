<!--
Antonio Faienza
Questo script serve per aggioranre l'immagine. Per fare questo eseguiamo una sere di query:
1- PRIMA QUERY: select per individuare l'immagine nel db
2- Setto a null l'immagine (in questo modo se tornassimo in HomeImpiantoSporitivo verrebbe caricata l'immagine di default)
3- Richiamo upload.php che a questo punto aggiorna l'immagine 
-->
<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Aggiornamento foto</title>
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
			        <li class="active">
						<a href="../impianto/homeImpiantoSportivo.php">Home</a>
			        </li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prenotazioni e Campi<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../impianto/campo.php">Visualizza campi</a></li>
							<li><a href="../impianto/prenotazioniPartiteSingole.php">Prenotazioni Utente/Privata</a></li>
						</ul>
					</li>
					<li class="dropdown">
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
                            <li><a href="../impianto/updatefoto.php">Carica foto</a></li>
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
					<h3 class="panel-title">Aggiornamento foto profilo</h3>
				</div>
				<div class="panel-body">
					<form action="upload.php" method="POST">
						<div class="form-group">
							<label for="scelta">Scegli quale immagine aggiornare</label>
							<select class='form-control' id='scelta' name="TendinaAggiornamento"> 
			                	<option value ='<?php echo $_SESSION["Percorso1"];?>'>Immagine 1</option>
								<option value ='<?php echo $_SESSION["Percorso2"];?>'>Immagine 2</option>
								<option value ='<?php echo $_SESSION["Percorso3"];?>'>Immagine 3</option>
			            	</select>
			            </div>
			            <div class="form-group">
			            	<label for="scelta">Carica immagine</label>
							<input type="file" name="fileToUpload" id="scelta">
			            </div>
						<button type='submit' class="btn btn-success btn-block">Aggiorna</button>
		        	</form>
				</div>
	    	</div>
	    </div>
	</div>
    </body>
</html>
