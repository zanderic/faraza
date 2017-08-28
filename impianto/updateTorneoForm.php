<!DOCTYPE html>
<!--
author Antonio Faienza
....In Questo script, vengono svolte le seguenti operazioni:
* si crea una tabella dinamica. Tale tabella è quella relativa al torneo scelto nel menù a tendina nello script:
  VisualizzaTornei.php -> $_SESSION["TorneoScelto"]
* si modificano i campi di interesse e nell'effettuare l'update (si veda codice UpdateTorneo.php)
  vengono sovrascritti tutti i valori come già capitato nello script UpdateInfo.php
-->
<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
	
	$today = date('Y-m-d');
?>
<!DOCTYPE html>
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
                        <li><a href="../impianto/creaTorneoForm.php">Crea Tornei</a></li>
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
				<h3 class="panel-title">Aggiorna <?php echo $_SESSION['TorneoScelto']; ?></h3>
			</div>
			<div class="panel-body">
				<form role="form" method='POST' action='UpdateTorneo.php'>
<?php
        $_SESSION["TorneoScelto"]=$_POST["Dettagli"];
        try {
            $sql3 = 'SELECT nome, tipo, costo, inizioTorneo, fineTorneo, inizioIscrizioni, fineIscrizioni, numeroMinimoSquadre FROM faraza.torneo WHERE nome = "'.$_SESSION["TorneoScelto"].'" ';
            $risultato3 = $_GLOBAL["pdo"]->query($sql3); 
        } catch (PDOException $ex) {
            echo "Qualcosa non è andato " . $ex->getMessage();
        }
        while ($row = $risultato3->fetch()) {
            echo '<div class="form-group"> 
            <label for="text">Nome Torneo</label>
            <input type="text" id="text" name="NomeTorneoUpdate" class="form-control" value="'.$row["nome"].'" disabled>
            </div>';
            
            echo '<div class="form-group">
            <label for="tipo">Tipo</label>
            <select name="TipoTorneoUpdate" id="tipo" class="form-control">
            <option value="5" selected>'.$_SESSION["Tipo_t"].'</option>
            <option value="7">7</option>
            </select>
            </div>';
            
            $_SESSION["Costo_t"] = $row["costo"];
            echo '<div class="form-group"> 
            <label for="number">Costo</label>
            <input  type="number" id="number" name="CostoTorneoUpdate" class="form-control" value="'.$_SESSION["Costo_t"].'">
            </div>';
            
            $_SESSION["Inizio_t"] = $row["inizioTorneo"];
            echo '<div class="form-group"> 
            <label for="inizio">Inizio Torneo</label>
            <input type="date" id="inizio" name="InizioTorneoUpdate" class="form-control" min="'.$today.'" value="'.$_SESSION["Inizio_t"].'">
            </div>';
            
            
             $_SESSION["fine_t"] = $row["fineTorneo"];
             echo '<div class="form-group"> 
            <label for="fine">Fine Torneo</label>
            <input type="date" id="fine" name="FineTorneoUpdate" class="form-control" min="'.$today.'" value="'.$_SESSION["fine_t"].'" >
            </div>';
            
            $_SESSION["InizioIscrizioni_t"] = $row["inizioIscrizioni"];
            echo '<div class="form-group"> 
            <label for="iniziois">Inizio Iscrizioni</label>
            <input type="date" id="iniziois" name="InizioIscrizioniUpdate" class="form-control" min="'.$today.'" value="'.$_SESSION["InizioIscrizioni_t"].'" >
            </div>';
            
            $_SESSION["FineIscrizioni_t"] = $row["fineIscrizioni"];
            echo '<div class="form-group"> 
            <label for="fineis">Fine Iscrizioni</label>
            <input type="date" id="fineis" name="FineIscrizioniUpdate" min="'.$today.'" class="form-control" min="'.$_SESSION["InizioIscrizioni_t"].'" value="'.$_SESSION["FineIscrizioni_t"].'" >
            </div>';
            
            $_SESSION["NumSquad"] = $row["numeroMinimoSquadre"];
            echo '<div class="form-group"> 
            <label for="number">Numero minimo squadre</label>
            <input type="number" id="number" name="NumSquadUpdate" class="form-control" min="3" value="'.$_SESSION["NumSquad"].'" >
            </div>';
        }
?>
				<button type='submit' class='btn btn-success btn-block'>Aggiorna</button>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
