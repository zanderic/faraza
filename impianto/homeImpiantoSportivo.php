<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Impianto Sportivo</title>
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
<?php
	// Recupero immagini profilo
    try {
       $sqlImage = 'SELECT Path1, Path2, Path3 FROM faraza.impiantoSportivo WHERE ID="'.$_SESSION["ID_Centro"].'"';
       $resPath = $_GLOBAL["pdo"]->query($sqlImage);
	} catch (PDOExceptionException $ex) {
		echo "Qualcosa non è andato..." .$ex->getMessage();
	}
	$risultatoPath = $resPath->fetch();
	if ($risultatoPath["Path1"]) {
		$_SESSION["Percorso1"] = $risultatoPath["Path1"];
	} else if($risultatoPath["Path1"]=="") {
		$_SESSION["Percorso1"] = "../foto/default.jpg";
	}
	if ($risultatoPath["Path2"]) {
		$_SESSION["Percorso2"] = $risultatoPath["Path2"];
	} else if($risultatoPath["Path2"]=="") {
		$_SESSION["Percorso2"] = "../foto/default.jpg";
	}
	if ($risultatoPath["Path3"]) {
		$_SESSION["Percorso3"] = $risultatoPath["Path3"];
	} else if($risultatoPath["Path3"]=="") {
		$_SESSION["Percorso3"] = "../foto/default.jpg";
	}
	
	if($risultatoPath["Path1"]!="" && $risultatoPath["Path2"]!="" && $risultatoPath["Path3"]!="") { 
		// Disattiva bottone
	}
?>
	<div class="row">
		<div class="col-md-4 col-md-offset-1">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<?php echo '<img src = "' . $_SESSION["Percorso1"] . '">'; ?>
					</div>
					<div class="item">
						<?php echo '<img src = "' . $_SESSION["Percorso2"] . '">'; ?>
					</div>
					<div class="item">
						<?php echo '<img src = "' . $_SESSION["Percorso3"] . '">'; ?>
					</div>
				</div>
				<!-- Left and right controls -->
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Indietro</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Avanti</span>
				</a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Commenti</h3>
				</div>
				<div class="panel-body">
					<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Utente</th>
                	<th>Data</th>
                	<th>Voto</th>
                	<th>Commento</th>
                	</tr>
                	</thead>
                	<tbody>		
<?php
            // Visualizziamo tutti quelli che sono i commenti 
            try {
                // Query sulla view vediCommenti (vogliamo l'ID dell'ImpiantoSportivo loggato)
                $sqlComment = 'SELECT nome, cognome, data, voto, commento FROM vediCommenti WHERE IDCentro = "'.$_SESSION["ID_Centro"].'"';
                $resultComment = $_GLOBAL["pdo"]->query($sqlComment);
            } catch (Exception $ex) {
	            echo "Qualcosa non è andato nella chiamata alla view " .$ex->getMessage();
            }             
            while($rowComment = $resultComment->fetch())
            {
                echo "<tr>";
                $_SESSION["utdn"] = $rowComment["nome"];
                $_SESSION["utdc"] = $rowComment["cognome"];
                echo '<td>'.$_SESSION["utdn"].' '.$_SESSION["utdc"].' </td>'; 
                
                $_SESSION["date"] = $rowComment["data"];
                $correct_date = date('d-m-Y', strtotime($_SESSION["date"]));
                echo '<td>'.$correct_date.'</td>'; 
                
               
                $_SESSION["result"] =$rowComment["voto"];
                echo '<td>'.$_SESSION["result"].'</td>'; 
                
               
                $_SESSION["comment"] =$rowComment["commento"];
                echo '<td>'.$_SESSION["comment"].'</td>';
                echo "</tr>";
            }
?>
                	</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Prenotazioni</h3>
				</div>
				<div class="panel-body">
					<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Campo</th>
                	<th>Data</th>
                	<th>Inizio</th>
                	<th>Fine</th>
					<th>Tipo partita</th>
                	</tr>
                	</thead>
                	<tbody>
<?php
			// qui verranno visualizzate tutte quelle che sono le prenotazioni in gererale da parte del torneo (di qualunque tipo di partita)
            try {
                $sqlPrenotazioni = 'SELECT p.numCampo, p.dataPrenotazione, p.oraInizio, p.oraFine, p.tipoPartita FROM faraza.prenotazione as p WHERE IDCentroSportivo = "' . $_SESSION["ID_Centro"] . '"';
                $risPrenotazioni = $_GLOBAL["pdo"]->query($sqlPrenotazioni);
            } catch (PDOException $ex) {
                echo "La registrazioni totali" . $ex->getMessage();
            }
            while($rowPrenotazioni = $risPrenotazioni->fetch())
            {
                echo "<tr>";
                $_SESSION["NumCampo"] = $rowPrenotazioni["numCampo"];
                echo '<td>'.$_SESSION["NumCampo"].'</td>';
                
                $_SESSION["data_prenotazione"] = $rowPrenotazioni["dataPrenotazione"];
                $correct_date = date('d-m-Y', strtotime($_SESSION["data_prenotazione"]));
                echo '<td> '.$correct_date.'</td>';
                
                $_SESSION["Ora_Inizio"] = $rowPrenotazioni["oraInizio"];
                $inizio = date('H:i', strtotime($_SESSION["Ora_Inizio"]));
                echo '<td>'.$inizio.'</td>';
                
                $_SESSION["Ora_Fine"] = $rowPrenotazioni["oraFine"];
                $fine = date('H:i', strtotime($_SESSION["Ora_Fine"]));
                echo '<td>'.$fine.'</td>';
                
                $_SESSION["Tipo_Partita"] = $rowPrenotazioni["tipoPartita"];
                echo '<td>'.$_SESSION["Tipo_Partita"].'</td>';
            }
?>
                	</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
    <!-- Disattivo il back buttom del browser in modo che  se sono loggato, l'unico modo per distruggere la sessiose sia il il logout -->
    <script>
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button"; // Again because google chrome don't insert first hash into history
        window.onhashchange=function(){window.location.hash="no-back-button";}
    </script>      
</body>
</html>