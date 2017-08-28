<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Pagelle</title>
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
<?php	
	try {
	    $sqlCountPagellaTorneo = 'SELECT count(vt.ID) as c FROM faraza.impiantosportivo as i, faraza.prenotazione as p, faraza.partitatorneo as pt, faraza.vistaPagellaTorneo as vt
										WHERE i.ID = '.$_SESSION["ID_Centro"].' AND i.ID = p.IDCentroSportivo AND pt.IDPrenotazione = p.ID AND pt.ID = vt.partita; ';
		$resCountPagellaTorneo= $_GLOBAL["pdo"]->query($sqlCountPagellaTorneo);
    } catch (PDOExceptionException $ex) {
		echo "Qualcosa nella SELECT PAGELLA non è andato: ".$ex->getMessage();
    }
    $rowCountPagTorneo = $resCountPagellaTorneo->fetch();
    if($rowCountPagTorneo["c"] == 0) {
        echo "<div class='alert alert-danger' role='alert' align='middle'>Nessun utente ha rilasciato una pagella, riprovare più tardi
                <br><br><a class='btn btn-danger' href='homeImpiantoSportivo.php' role='button'>OK</a>	
                </div>";
    } else {
?>
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
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tornei<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
                        <li><a href="../impianto/creaTorneoForm.php">Crea Tornei </a></li>
                        <li><a href="../impianto/visualizzaTornei.php">Visualizza Tornei</a></li>
                        <li class="divider"></li>
                        <li><a href="../torneo/creazioneTornei.php">Processa tornei</a></li>
		            </ul>
				</li>
				<li class="dropdown active">
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
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Pagelle di Partite Torneo</h3>
			</div>
			<div class="panel-body">
				<table class='table table-hover'>
            	<thead>
            	<tr>
            	<th>#</th>
            	<th>Da</th>
            	<th>Voto</th>
				<th>Commento</th>
				<th>A</th>
				<th>Partita</th>
            	</tr>
            	</thead>
            	<tbody>
<?php
	    try {
			$sqlPagellaTorneo = 'SELECT vt.* FROM faraza.impiantosportivo as i, faraza.prenotazione as p, faraza.partitatorneo as pt, faraza.vistaPagellaTorneo as vt
			                   WHERE i.ID = '.$_SESSION["ID_Centro"].' AND i.ID = p.IDCentroSportivo AND pt.IDPrenotazione = p.ID AND pt.ID = vt.partita';
			$resPagellaTorneo = $_GLOBAL["pdo"]->query($sqlPagellaTorneo);
	    } catch (PDOExceptionException $ex) {
			echo "Qualcosa nella SELECT PAGELLA non è andato...".$ex->getMessage();
	    }
	    $count = 1;
	    while($rowPagellaTorneo = $resPagellaTorneo->fetch()) {
	        echo "<tr>";
	        $_SESSION["idt"] = $rowPagellaTorneo['ID'];
	        echo '<td>'.$count.'</td>';
	        
	        $_SESSION["namet"] = $rowPagellaTorneo['nome'];
	        $_SESSION["surnamet"]= $rowPagellaTorneo['cognome'];
	        echo '<td>'.$_SESSION["namet"].' '.$_SESSION["surnamet"].'</td>';
	        
	        $_SESSION["votet"] = $rowPagellaTorneo['voto'];
	        echo '<td>'.$_SESSION["votet"].'</td>';
	        
	        $_SESSION["commentt"] = $rowPagellaTorneo['commento'];
	        echo '<td>'.$_SESSION["commentt"].'</td>';
	        
	        $_SESSION["nome_votatot"] = $rowPagellaTorneo['nomeVotato'];
	        $_SESSION["cognome_votatot"] = $rowPagellaTorneo['cognomeVotato'];
	        echo '<td>'.$_SESSION["nome_votatot"].' '.$_SESSION["cognome_votatot"].'</td>';
	        
	        $_SESSION["idmatch"] = $rowPagellaTorneo['partita'];
	        echo '<td>'.$_SESSION["idmatch"].'</td>';
	        echo "</tr>";
	        $count++;
	    }
?> 
            	</tbody>
				</table>
		<form method='POST'>
			<label for='id_pagellaTorneo'>Seleziona commento da eliminare</label>
			<select name='pagella' class='form-control'>
<?php
		try {
            $sqlPagellaTorneo = 'SELECT vt.* FROM faraza.impiantosportivo as i, faraza.prenotazione as p, faraza.partitatorneo as pt, faraza.vistaPagellaTorneo as vt
            				WHERE i.ID = '.$_SESSION["ID_Centro"].' AND i.ID = p.IDCentroSportivo AND pt.IDPrenotazione = p.ID AND pt.ID = vt.partita';
            $risultatoPagellaTorneo = $_GLOBAL["pdo"]->query($sqlPagellaTorneo);
            $count = 1;
            while ($righepagTorneo=$risultatoPagellaTorneo->fetch()) {
                echo '<option value='.$righepagTorneo["ID"].'>'.$count.'</option>';
                $count++;
            }
        } catch (PDOException $ex) {
			echo "Qualcosa nella select non è andato ".$ex->getMessage();
        }
        echo "</select><br>";
        echo "<button type='submit' name='cancellazione' class='btn btn-success btn-block'>Elimina</button>";
        echo "</form>";
        // Se è stato fatto submit viene ricaricata la pagina
        // Cancellazione della pagella che si è deciso di elimianare
        if(isset($_POST['cancellazione'])) {
            $_SESSION["pagellaTorneo"] = $_POST["pagella"];
            try {
                $sqlDelete = 'DELETE FROM faraza.pagellaPartitaTorneo WHERE ID='.$_SESSION["pagellaTorneo"].'';
                $risDelete = $_GLOBAL["pdo"]->query($sqlDelete);
            } catch (PDOException $ex) {
            	echo "Cancellazione pagella non andata a buon fine " .$ex->getMessage();
            }
			echo "<br><div class='alert alert-success' role='alert' align='middle'>Pagella cancellata correttamente!
                <br><br><a class='btn btn-success' href='pagellePartiteTorneo.php' role='button'>OK</a>	
                </div>";
		}    
	}
?>
			</div>
		</div>
	</div>
</div>
</body>
</html>