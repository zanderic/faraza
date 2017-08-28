<!DOCTYPE html>
<!--
author Antonio Faienza
-->
<?php 
include_once ("../connessioneDB.php");
               global $_GLOBAL;
               session_start();
?>
<html>
    <head>
       
        <title>Faraza - Cencellati da Faraza</title>
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
                    <a class="navbar-brand" href="homeImpiantoSportivo.php"><?php echo $_SESSION["Nome_centro"] ?></a>
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
                                    <a href="homeImpiantoSportivo.php">Home</a>
			        </li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prenotazioni e Campi<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="campo.php">Visualizza campi</a></li>
							<li><a href="prenotazioniPartiteSingole.php">Prenotazioni Utente/Privata</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tornei<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="creaTorneoForm.php">Crea Tornei </a></li>
                                                    <li><a href="visualizzaTornei.php">Visualizza Tornei</a></li>
			            </ul>
					</li>
					<li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pagelle<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="pagellePartiteUtente.php">Pagelle Utente</a></li>
                                                    <li><a href="pagellePartiteTorneo.php">Pagelle Torneo</a></li>
						</ul>
					</li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
				    <li class="dropdown active">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Opzioni<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="visualizzaInfo.php">Visualizza Informazioni</a></li>
							<li><a href="../utente/caricaimmagine.php">Aggiorna foto</a></li>
							<li class="divider"></li>
                                                        <li><a href="cancellaDaPiattaformaForm.php">Cancellati da Faraza</a></li>
						</ul>
					</li>
				    <li><a href="../logout.php">Logout</a></li>
			    </ul>
			</div>
		</div>
	</nav>
           <p>
        <?php
        echo "<form method=POST action='cancellaDaPiattaforma.php'>";
       // echo "<h3> Sei sicuro di volerti eliminare? </h3>";
        echo "<div class='alert alert-success' role='alert' align='middle'><h3> Sei sicuro di volerti eliminare? </h3>
                    <br><br>
                    </div>";
        echo "<br><input  type='submit' name='conferma_eliminazione_piattaforma' size='25' Value=Conferma></td> ";
        echo "</form>";
        echo "<input type=button name=esci id=esci value='Torna Indietro' onclick=javascript:location.href='homeImpiantoSportivo.php'>";

        ?>
    </body>
</html>
