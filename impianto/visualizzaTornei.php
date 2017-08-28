<!DOCTYPE html>
<!--
author Antonio Faienza
L'obiettivo di questo script è di visualizzare tutti i tornei creati da un centro sportivo.
Per fare questo, creaiamo una tabella dinamica frutto della query. 
Per modificare i vari campi, è stato creato un menù a tendina dove si sceglie il torneo, 
si viene riamandati alla pagina UpdateTorneoForm
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
<?php
    try {
        $sqlCount = 'SELECT count(*) as ris FROM faraza.torneo WHERE IDImpiantoSportivo = "'.$_SESSION["ID_Centro"].'" ';
        $risCount = $_GLOBAL["pdo"]->query($sqlCount);
    } catch (PDOException $ex) {
        echo "La query non è andata buon fine" .$ex->getMessage();
    }
    
    $rowCount = $risCount->fetch();
    if($rowCount['ris']==0) {
        echo "<div class='alert alert-danger' role='alert' align='middle'>Non esistono tornei in programma. Torna indietro per crearne uno!
				<br><br><a class='btn btn-danger' href='homeImpiantoSportivo.php' role='button'>OK</a>	
				</div>";
    } else {
        try {
            $sql = 'SELECT nome, tipo, costo, inizioTorneo, fineTorneo, inizioIscrizioni, fineIscrizioni, numeroMinimoSquadre FROM faraza.torneo WHERE IDImpiantoSportivo = "'.$_SESSION["ID_Centro"].'" ';
            $risultato = $_GLOBAL["pdo"]->query($sql); 
        } catch (PDOException $ex) {
	        echo "Qualcosa non è andato " . $ex->getMessage();
        }
	}
?>
	<div class="row">
		<div class="col-md-offset-1 col-md-5">
			<div class="panel panel-success">
				<div align="center" class="panel-heading">
					<h3 class="panel-title">Tornei in programma</h3>
				</div>
<?php
        while ($row = $risultato->fetch()) {
	        echo "<div class='panel-body'>";
            echo "<table class='table table-hover'>
            	<tbody>";
            echo "<tr>";
            echo "<th> Nome Torneo </th>";            
            $_SESSION["Nome_t"] = $row["nome"];
            echo '<td> '.$_SESSION["Nome_t"].' </td>';            
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Tipo</th>";
            $_SESSION["Tipo_t"] = $row["tipo"];
            echo '<td> '.$_SESSION["Tipo_t"].' </td>';           
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Costo</th>";
            $_SESSION["Costo_t"] = $row["costo"];
            echo '<td> '.$_SESSION["Costo_t"].' </td>';           
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Inizio Torneo</th>";
            $_SESSION["Inizio_t"] = $row["inizioTorneo"];
            $inizio = date('d-m-Y', strtotime($_SESSION["Inizio_t"]));
            echo '<td> '.$inizio.' </td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Fine Torneo</th>";
            $_SESSION["fine_t"] = $row["fineTorneo"];
            $fine = date('d-m-Y', strtotime($_SESSION["fine_t"]));
            echo '<td> '.$fine.' </td>';
            
            echo "</tr>";
            echo "<tr>";
            echo "<th>Inizio Iscrizioni</th>";
            $_SESSION["InizioIscrizioni_t"] = $row["inizioIscrizioni"];
            $iniziois = date('d-m-Y', strtotime($_SESSION["InizioIscrizioni_t"]));
            echo '<td> '.$iniziois.' </td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Fine Iscrizioni</th>";
            $_SESSION["FineIscrizioni_t"] = $row["fineIscrizioni"];
			$fineis = date('d-m-Y', strtotime($_SESSION["FineIscrizioni_t"]));
			echo '<td> '.$fineis.' </td>';            
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Numero minimo Squadre</th>";
            $_SESSION["NumSquad"] = $row["numeroMinimoSquadre"]; 
            echo '<td> '.$_SESSION["NumSquad"].' </td>';
            echo "</tr>
            	</tbody>
            	</table>
            	</div>
            	<div class='panel-heading'></div>";
        }
?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Seleziona torneo</h3>
				</div>
				<div class='panel-body'>					
			        <form id='form' method='POST'>
				        <label for="IdDropDownList">Seleziona torneo</label>
						<select id='IdDropDownList' name='Dettagli' class='form-control'>
<?php
		//	Tramite questo script php faccio:
		//	* select dei tornei disponibili
		//	* costruisco drop down list con i risultati della select per poter aggiornare le info.         
        try {
            $sql2 = 'SELECT nome FROM faraza.torneo WHERE (IDImpiantoSportivo = "'.$_SESSION["ID_Centro"].'" )';
            $risultato2 = $_GLOBAL["pdo"]->query($sql2); 
            
            while ($righe=$risultato2->fetch()) {
                echo '<option value= "'.$righe["nome"].'" >'.$righe["nome"].'</option>';
            }
        } catch (PDOException $ex) {
			echo "Qualcosa nella select non è andato"    .$ex->getMessage();
        }
?>
						</select>
						<br>
						<button id='submit_aggiorna' type='submit' class="btn btn-success">Aggiorna</button>
						<button id='submit_squadre' type='submit' class="btn btn-success">Squadre</button>
						<button id='submit_partite' type='submit' class="btn btn-success">Partite</button>
						<button id='submit_classifica' type='submit' class="btn btn-success">Classifica</button>
						<button id='submit_elimina' type='submit' class="btn btn-success">Elimina</button>
			        </form>
				</div>
			</div>
		</div>
		</div>
        <script>
        $(document).ready(function(){
            $('#submit_aggiorna').click(function() {
                $('#form').attr('action', 'updateTorneoForm.php')
            });
            $('#submit_squadre').click(function() {
                $('#form').attr('action', 'visualizzaSquadre.php')
            });
            $('#submit_partite').click(function() {
                $('#form').attr('action', 'partiteTorneo.php')
            });
            $('#submit_classifica').click(function() {
                $('#form').attr('action', 'classifica.php')
            });
            $('#submit_elimina').click(function() {
                $('#form').attr('action', 'eliminaTorneoForm.php')
            });
        });
        </script>
    </body>
</html>
