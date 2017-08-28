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
    <title>Faraza - Home</title>
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
			        <li class="active">
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
					<li class="dropdown">
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
<?php
	$IDutente = $_SESSION["ID"];
	try {
		// Notifica INVITO ricevuto per partita Torneo
	    $sql = "SELECT * FROM faraza.utente WHERE ID = '$IDutente' AND visto = 1";
	    $res = $_GLOBAL['pdo']->query($sql);
	
		if ($riga = $res -> fetch()) {
			$sql = "UPDATE faraza.utente SET visto = 0 WHERE ID = '$IDutente'";
	        $res=$_GLOBAL['pdo']->query($sql);
	        
			echo '<script type="text/javascript">
				alert("Ti hanno invitato ad una partita, controlla la tua email!");
				</script>';
	    }
	    
	    // Controllo sulle PAGELLE ricevute - notifica popup
        $sql = "SELECT * FROM faraza.pagella WHERE IDGiocatore = $IDutente AND visto = 0";
        $res = $_GLOBAL['pdo']->query($sql);
        
		if($riga = $res -> fetch()) {
	        $sql = "UPDATE faraza.pagella SET visto = 1 WHERE IDGiocatore = $IDutente";
	        $res=$_GLOBAL['pdo']->query($sql);
	
			   echo '<script type="text/javascript">
	              alert("Hai ricevuto una valutazione per una Partita Utente. Clicca su - Visualizza pagelle ricevute - per scoprire che cosa pensano di te i tuoi avversari!");
	              </script>';
		}
		
		// Notifica commento ricevuto per partita Torneo
        $sql = "SELECT * FROM faraza.pagellapartitatorneo WHERE IDGiocatore=$IDutente AND visto=0";
        $res=$_GLOBAL['pdo']->query($sql);

		if($riga = $res -> fetch()) {
	        $sql = "UPDATE faraza.pagellapartitatorneo SET visto = 1 WHERE IDGiocatore=$IDutente";
	        $res=$_GLOBAL['pdo']->query($sql);
	        
			echo '<script type="text/javascript">
	              alert("Hai ricevuto una valutazione per una Partita Torneo. Clicca su - Visualizza pagelle ricevute - per scoprire che cosa pensano di te i tuoi avversari!");
	              </script>';
	    }
		
		// Controllo sui BIDONI    
        $sql = 'SELECT bidoni, telefono FROM faraza.utente WHERE email="' . $_SESSION['mail'] . '"';
        $res = $_GLOBAL['pdo']->query($sql);
    
		$riga = $res -> fetch();
		if ($riga[0] != null) {
	        $bidoni = $riga[0];
	        $_SESSION['telefono'] = $riga[1];
	    }
        
        // Immagine profilo
		$sqlImage = 'SELECT Path1 FROM faraza.utente WHERE ID = "' . $_SESSION["ID"] . '" ';
		$resPath = $_GLOBAL["pdo"]->query($sqlImage);
		
		$risultatoPath = $resPath->fetch();
		if ($risultatoPath["Path1"]) {
		   $_SESSION["Percorso1"] = $risultatoPath["Path1"];
		} else if ($risultatoPath["Path1"] == "") {
			$_SESSION["Percorso1"] = "../foto/default.jpg";
		}
	} catch (PDOException $ex) {
        echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
        exit();
    }
?>
	<div class="row">
		<div class="col-md-2">
			<img src = <?php echo $_SESSION["Percorso1"]; ?> class = "img-responsive img-thumbnail" alt="Profile Pic">
		</div>
		<div class="col-md-offset-2 col-md-4">
<?php
			if($bidoni != 0) {
	        	echo "<div class='panel panel-warning'>
						<div class='panel-heading'>
							<h3 class='panel-title'>Attenzione i tuoi bidoni attualmente sono: " . $bidoni . "</h3>
						</div>
					</div>";
	        }
?>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-3">
			<a href="visualizzapagelleutente.php" class="btn btn-success" role="button">Visualizza pagelle ricevute</a>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Partite Private create</h3>
				</div>
<?php
		try {
	        $sql = "SELECT prenotazione.dataPrenotazione , impiantoSportivo.nomeCentro 
	                FROM partitaPrivata , utente , prenotazione , impiantosportivo
	                WHERE partitaPrivata.IDUtenteCreante=utente.ID AND partitaPrivata.IDPrenotazione=prenotazione.ID AND prenotazione.IDCentroSportivo=impiantosportivo.ID AND partitaPrivata.IDUtenteCreante=".						$_SESSION["ID"]."
	                ORDER BY prenotazione.dataPrenotazione";
	        $res = $_GLOBAL['pdo'] -> query($sql);
		echo "<table class='table table-hover'>
			<thead>
			<tr>
			<th>#</th>
			<th>Data</th>
			<th>Impianto sportivo</th>
			</tr>
			</thead>
			<tbody>";
		$cont = 1;
		while ($row = $res -> fetch()) {
			echo "<tr>";
			echo "<td>".$cont."</td>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "</tr>";
			$cont++;
		}
		echo "</tbody>
			</table>";
?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Partite Utente Aperte create</h3>
				</div>
<?php
        $sql = "SELECT dataPrenotazione, nomeCentro
                FROM faraza.partitautente, faraza.prenotazione, faraza.impiantosportivo
                WHERE partitautente.tipo = 'partitaAperta' AND  prenotazione.ID = partitautente.IDPrenotazione AND impiantosportivo.ID = prenotazione.IDCentroSportivo AND partitautente.IDUtenteCreante = ".						$_SESSION["ID"]."
                ORDER BY prenotazione.dataPrenotazione";
        $res = $_GLOBAL['pdo'] -> query($sql);
        
		echo "<table class='table table-hover'>
			<thead>
			<tr>
			<th>#</th>
			<th>Data</th>
			<th>Impianto sportivo</th>
			</tr>
			</thead>
			<tbody>";
		$cont = 1;
		while ($row = $res->fetch()) {
			echo "<tr>";
			echo "<td>".$cont."</td>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "</tr>";
			$cont++;
		}
		echo "</tbody>
			</table>";
?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Partite Utente Chiuse create</h3>
				</div>
<?php
        $sql = "SELECT dataPrenotazione, nomeCentro FROM faraza.partitautente, faraza.prenotazione, faraza.impiantosportivo
        		WHERE partitautente.tipo = 'partitaChiusa' AND prenotazione.ID = partitautente.IDPrenotazione AND impiantosportivo.ID = prenotazione.IDCentroSportivo AND partitautente.IDUtenteCreante = ".						$_SESSION['ID']."
        		ORDER BY prenotazione.dataPrenotazione";
        $res = $_GLOBAL['pdo'] -> query($sql);

		echo "<table class='table table-hover'>
			<thead>
			<tr>
			<th>#</th>
			<th>Data</th>
			<th>Impianto sportivo</th>
			</tr>
			</thead>
			<tbody>";
		$cont = 1;
		while ($row = $res -> fetch()) {
			echo "<tr>";
			echo "<td>".$cont."</td>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "</tr>";
			$cont++;
		}
		echo "</tbody>
			</table>";
?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Squadre di tornei</h3>
				</div>
<?php
        $sqlInfoTorneo = 'SELECT t.nome as nt ,s.nome as ns , g.goalFatti as gf  
                          FROM faraza.utente as u, faraza.giocatore as g, faraza.squadra as s, faraza.partecipa as p, faraza. torneo as t 
                          WHERE u.ID = g.IDGiocatore AND g.IDSquadra=s.ID AND s.ID=p.IDSquadra AND p.nomeTorneo = t.nome AND u.ID = '.$_SESSION['ID'].'';
        $resInfoTorneo=$_GLOBAL['pdo']->query($sqlInfoTorneo);
        
        echo "<table class='table table-hover'>
        	<thead>
        	<tr>
        	<th>#</th>
        	<th>Nome torneo</th>
            <th>Squadra</th>
            <th>Goal fatti</th>
            <th>Classifica marcatori</th>
            </tr>
            </thead>
            <tbody>";
        $cont = 1;
        while($rowInfoTorneo = $resInfoTorneo->fetch()) {
            echo '<tr>';
            echo '<td>'.$cont.'</td>';
            echo '<form method="GET" action="classificaTorneo.php">';
            echo '<td><a href=../torneo/classificaTorneo.php?torneoScelto='.$rowInfoTorneo['nt'].'>'.$rowInfoTorneo['nt'].'</a></td>';
            echo '</form>';
            echo '<td>'.$rowInfoTorneo['ns'].'</td>';
            echo '<td>'.$rowInfoTorneo['gf'].'</td>';
            echo '<form method="GET" action="classificaMarcatori.php">';
            echo '<td><a href=../torneo/classificaMarcatori.php?marcatori='.$rowInfoTorneo['nt'].'>Classifica marcatori</a></td>';
            echo '</form>';
            echo '</tr>';
            $cont++;
        }
        echo "</tbody>
        	</table>";
    } catch (Exception $ex) {
        echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex -> getMessage();
        exit();
    }
?>
			</div>
		</div>
	</div>
	<!-- Disattivo il back buttom del browser in modo che se sono loggato, l'unico modo per distruggere la sessione sia il logout-->
    <script>
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
        window.onhashchange=function(){window.location.hash="no-back-button";}
    </script>
</body>
</html>