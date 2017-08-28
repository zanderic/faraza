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
<?php
	$_SESSION["Veditorneo"]=$_POST["Dettagli"];
        
    try {
        $sqlVerificaPartite = 'SELECT count(*) as num FROM faraza.partitatorneo WHERE nomeTorneo="'.$_SESSION["Veditorneo"].'"';
        $risultatocount = $_GLOBAL["pdo"]->query($sqlVerificaPartite);
    } catch (PDOException $ex) {
        echo 'count partite ' .$ex->getMessage();
    }
    $rowConta=$risultatocount->fetch();
    if($rowConta['num'] == 0) {
        echo "<div class='alert alert-danger' role='alert' align='middle'>Le partite di questo torneo devono ancora essere decise.<br>Si prega di riprovare piu' tardi.
			<br><br><a class='btn btn-danger' href='visualizzaTornei.php' role='button'>OK</a>	
			</div>";
    } else {
	    try {
            // Join tra le due viste
            $sqlPartiteTorneo = 'SELECT a.squadra as sa, b.squadra as sb , a.punteggio as pa, b.punteggio as pb, p.numCampo, 
                                        p.dataPrenotazione, p.oraInizio, p.oraFine, a.IDPartita as idp, a.IDPrenotazione as idpr
                                 FROM faraza.infoSquadraA as a, faraza.infoSquadraB as b, faraza.prenotazione as p
                                 WHERE a.IDPartita=b.IDPartita AND p.ID = a.IDPrenotazione AND p.ID = b.IDPrenotazione AND a.nomeTorneo="'.$_SESSION["Veditorneo"].'"';
            $resPartiteTorneo = $_GLOBAL["pdo"]->query($sqlPartiteTorneo); 
        } catch (PDOException $ex) {
            echo 'query parite squadre non andata a buon fine ' .$ex->getMessage();
        }
?>
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
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $_SESSION["Veditorneo"];?> - Partite in programma</h3>
				</div>
				<div class="panel-body">
					<form method='POST' action='updatePunteggioPartitaTorneo.php'>
						<table class='table table-hover'>
	                		<thead>
								<tr>
			                	<th>Casa</th>
			                	<th>Ospite</th>
			                	<th>Punteggio Casa</th>
			                	<th>Punteggio Ospite</th>
								<th>Campo</th>
								<th>Data</th>
								<th>Inizio</th>
								<th>Fine</th>
			                	</tr>
							</thead>
							<tbody>
<?php 	
		$data_attuale = date("Y-m-d");
	    
	    // Questa variabile serve per poter cambiare i nomi degli input-text dinamicamente e poter quindi aggiornare i punteggi
	    $_SESSION['i'] = 1;
	    // Salviamo gli id all'interno di un array in modo da poter essere richiamati in updatePunteggioPartitaTorneo.
	    $_SESSION['arrayid'] = array();
	    $j = 0;
	    while($rowPartiteTorneo=$resPartiteTorneo->fetch()) {
	        echo "<tr>";
	        array_push($_SESSION['arrayid'], $rowPartiteTorneo["idp"]); // aggiorniamo l'ID
	        
	        $_SESSION['squadraA']=$rowPartiteTorneo["sa"];
	        echo '<td>'.$_SESSION["squadraA"].'</td>';
	        
	        $_SESSION['squadraB']=$rowPartiteTorneo["sb"];
	        echo '<td>'.$_SESSION["squadraB"].'</td>';
	        
	        if($rowPartiteTorneo['dataPrenotazione'] > $data_attuale) {    
	            $_SESSION['punteggioA']=$rowPartiteTorneo["pa"];
	            echo '<td><input class="form-control" id=id_punteggioA type=text name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioA"].' disabled=TRUE ></td>';
	            echo '<input class="form-control" type="hidden" name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioA"].'>';
	            $_SESSION['i'] = $_SESSION['i']+1 .'         ';
	            $_SESSION['punteggioB']=$rowPartiteTorneo["pb"];
	            echo '<td><input class="form-control" id=id_punteggioB type=text name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioB"].' disabled=TRUE ></td>';
	            echo '<input class="form-control" type="hidden" name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioA"].'>';
	        } else {
	            $_SESSION['punteggioA']=$rowPartiteTorneo["pa"];
	            echo '<td><input class="form-control" id=id_punteggioA type=text name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioA"].' ></td>';
				
				$_SESSION['i'] = $_SESSION['i']+1;
	            $_SESSION['punteggioB']=$rowPartiteTorneo["pb"];
	            echo '<td><input class="form-control" id=id_punteggioB type=text name=punteggio'.$_SESSION['i'].' value='.$_SESSION["punteggioB"].' ></td>';
	        }
	        $_SESSION['campo']=$rowPartiteTorneo["numCampo"];
	        echo '<td>'.$_SESSION["campo"].' </td>';
	        
	        $_SESSION['data']=$rowPartiteTorneo["dataPrenotazione"];
	        $correct_date = date('d-m-Y', strtotime($_SESSION["data"]));
	        echo '<td>'.$correct_date.' </td>';
	        
	        $_SESSION['inizio']=$rowPartiteTorneo["oraInizio"];
	        $inizio = date('H:i', strtotime($_SESSION["inizio"]));
	        echo '<td>'.$inizio.' </td>';
	        
	        $_SESSION['fine']=$rowPartiteTorneo["oraFine"];
	        $fine = date('H:i', strtotime($_SESSION["fine"]));
	        echo '<td>'.$fine.'</td>';
	        echo "</tr>";
	        $_SESSION['i'] = $_SESSION['i']+1;
	    }
	   
	    echo "</tbody>
	    	</table>  
			<button type='submit' class='btn btn-success btn-block'>Aggiorna punteggio</button>
			</form>";
	}
?>       
    </body>
</html>
