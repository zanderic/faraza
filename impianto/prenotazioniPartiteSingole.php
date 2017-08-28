<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Prenotazioni</title>
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
				<li class="dropdown active">
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
        try {
            $sqlCountPr = "SELECT count(ID) as pr FROM faraza.prenotazione WHERE IDCentroSportivo = ".$_SESSION["ID_Centro"]." AND (tipoPartita = 'partitaUtente' OR tipoPartita='partitaPrivata')";
            $risCountPr = $_GLOBAL["pdo"]->query($sqlCountPr);
        } catch (PDOException $ex) {
            echo "Il count sulle prenotazioni non è andata a buon fine" .$ex->getMessage();
        }
        $rowCountPr = $risCountPr->fetch();
        if($rowCountPr["pr"]==0) {
            echo '<script type="text/javascript">
                  alert("Non ci sono prenotazioni");
                  window.location.assign("homeImpiantoSportivo.php")
                  </script>';
        } else { 
	        try {
				// Per risparmiare codice relativo alla costruzione delle tabelle, si realizza una doppia query che racchiude tutti i risultati inerenti sia le partite Private che quelle pubbliche
	            $sqlPartitaUtente ='SELECT p.numCampo, p.dataPrenotazione, p.oraInizio, p.oraFine,p.tipoPartita, pu.punteggio, u.nome, u.cognome, u.ID
	                               FROM faraza.prenotazione as p, faraza.partitaUtente as pu, faraza.utente as u
	                               WHERE (p.ID=pu.IDPrenotazione) AND (p.IDCentroSportivo="'.$_SESSION['ID_Centro'].'") AND (pu.IDUtenteCreante = u.ID)';
				$risPrenotazioniUtente = $_GLOBAL["pdo"]->query($sqlPartitaUtente);
			} catch (PDOException $ex) {
	           echo "La select prenotazioni partiteUtente " . $ex->getMessage();
			}
?>        
<div class="row">
	<div div class="col-md-5 col-md-offset-1">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 align="center" class="panel-title">Partite Utente</h3>
			</div>
<?php			
			while($rowPartiteUtente=$risPrenotazioniUtente->fetch()) {
				echo "<div class='panel-body'>"; 
				echo "<table class='table table-hover'>"; 
				echo "<tbody>";
				echo "<tr>";
				echo "<th> Campo </th>";
				$_SESSION["numeroCampo"]=$rowPartiteUtente['numCampo'];
				echo '<td> '.$_SESSION["numeroCampo"].' </td>';            
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Data </th>";
				$_SESSION["Dataprenotazione"]= $rowPartiteUtente['dataPrenotazione'];
				$correct_date = date('d-m-Y', strtotime($_SESSION["date"]));
				echo '<td> '.$correct_date.' </td>';
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Inizio </th>";
				$_SESSION["start"]= $rowPartiteUtente['oraInizio'];
				$inizio = date('H:i', strtotime($_SESSION["start"]));
				echo '<td> '.$inizio.' </td>';            
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Fine </th>";
				$_SESSION["finish"]= $rowPartiteUtente['oraFine'];
				$fine = date('H:i', strtotime($_SESSION["finish"]));
				echo '<td> '.$fine.' </td>';
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Tipo </th>";
				$_SESSION["type"]=$rowPartiteUtente['tipoPartita'];
				echo '<td> '.$_SESSION["type"].' </td>';            
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Punteggio </th>";
				$_SESSION["punt"]=$rowPartiteUtente['punteggio'];
				echo '<td> '.$_SESSION["punt"].' </td>';            
				echo "</tr>";
				
				echo "<tr>";
				echo "<th> Utente Creante </th>";
				$_SESSION['ID_Giocatore_' . $rowPartiteUtente['ID']] = $rowPartiteUtente['ID'];
				$_SESSION["nome_prenotazioni_utente"] = $rowPartiteUtente['nome']; 
				$_SESSION["cognome_prenotazioni_utente"] = $rowPartiteUtente['cognome']; 
				echo '<td>  <a href=profiloUtente.php?send='.$_SESSION['ID_Giocatore_' . $rowPartiteUtente['ID']].'>'.$_SESSION["nome_prenotazioni_utente"].' '.$_SESSION["cognome_prenotazioni_utente"].'</a>  </td>';                                 
				echo "</tr>";
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
				echo "<div class='panel-heading'></div>";
			}
		}
?>       
		</div>
	</div>
	<div class="col-md-5"> 
		<div class="panel panel-success">
			<div align="center" class="panel-heading">
				<h3 class="panel-title">Partite Private</h3>
			</div>
<?php
				// partite private
				try {
                	$sqlPartitaPrivata ='SELECT p.numCampo, p.dataPrenotazione, p.oraInizio, p.oraFine,p.tipoPartita, u.nome, u.cognome, u.ID
                                    FROM faraza.prenotazione as p, faraza.partitaPrivata as pp, faraza.utente as u
                                    WHERE (p.ID=pp.IDPrenotazione) AND (p.IDCentroSportivo="'.$_SESSION['ID_Centro'].'") AND(pp.IDUtenteCreante = u.ID)';
					$risPrenotazioniPrivate = $_GLOBAL["pdo"]->query($sqlPartitaPrivata);
                } catch (PDOException $ex) {
	                echo "La select prenotazioni partiteUtente " . $ex->getMessage();
				}

				while($rowPartitePrivate=$risPrenotazioniPrivate->fetch()) {
					echo "<div class='panel-body'>";
					echo "<table class='table table-hover'>"; 
					echo "<tr>";
					echo "<th> Campo </th>";
					$_SESSION["numeroCampo2"]=$rowPartitePrivate['numCampo'];
					echo '<td>'.$_SESSION["numeroCampo2"].'</td>';
					echo "</tr>";
					
					echo "<tr>";
					echo "<th> Data </th>";
					$_SESSION["Dataprenotazione2"]= $rowPartitePrivate['dataPrenotazione'];
					$correct_date = date('d-m-Y', strtotime($_SESSION["Dataprenotazione2"]));
					echo '<td>'.$correct_date.'</td>';
					echo "</tr>";
					
					echo "<tr>";
					echo "<th> Inizio </th>";
					$_SESSION["start2"]= $rowPartitePrivate['oraInizio'];
					$inizio = date('H:i', strtotime($_SESSION["start2"]));
					echo '<td>'.$inizio.'</td>';
					echo "</tr>";
					
					echo "<tr>";
					echo "<th> Fine </th>";
					$_SESSION["finish2"]= $rowPartitePrivate['oraFine'];
					$fine = date('H:i', strtotime($_SESSION["finish2"]));
					echo '<td>'.$fine.'</td>';            
					echo "</tr>";
					
					echo "<tr>";
					echo "<th> Tipo </th>";
					$_SESSION["type2"]=$rowPartitePrivate['tipoPartita'];
					echo '<td>'.$_SESSION["type2"].'</td>';            
					echo "</tr>";
					
					echo "<tr>";
					echo "<th> Utente Creante </th>";
					$_SESSION['ID_Giocatore_' . $rowPartitePrivate['ID']] = $rowPartitePrivate['ID'];
					$_SESSION["nome_prenotazioni_private"]= $rowPartitePrivate['nome']; 
					$_SESSION["cognome_prenotazioni_private"]= $rowPartitePrivate['cognome'];  
					echo '<td><a href=profiloUtente.php?send='.$_SESSION['ID_Giocatore_' . $rowPartitePrivate['ID']].'>'.$_SESSION["nome_prenotazioni_private"].' '.$_SESSION["cognome_prenotazioni_private"].' </a></td>';                                 
					echo "</tr>";
					echo "</tbody>";
					echo "</table>";
					echo "</div>";
					echo "<div class='panel-heading'></div>";
				}
?>
			</div>
		</div>
	</div>
</body>
</html>
