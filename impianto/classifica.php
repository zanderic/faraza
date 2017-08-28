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
        $sqlCountClassifica = 'SELECT count(*) as c
                        FROM faraza.squadra as s, faraza.partecipa as p, faraza.torneo as t
                        WHERE   t.nome = "'.$_SESSION["Veditorneo"].'" AND s.ID = p.IDSquadra AND p.nomeTorneo = t.nome';
        $risCountClassifica = $_GLOBAL["pdo"]->query($sqlCountClassifica);
    } catch (PDOException $ex) {
        echo 'Errore nel count di visualizzazione delle squadre ' .$ex->getMessage();
    }
    $rowCountClassifica = $risCountClassifica->fetch();
	if($rowCountClassifica["c"]==0) {
                echo "<div class='alert alert-danger' role='alert' align='middle'>La classifica al momento non è disponibile.<br>Si prega di riprovare più tardi.
                <br><br><a class='btn btn-danger' href='visualizzaTornei.php' role='button'>OK</a>
                </div>";
	} else {
    	try {
			$sqlClassificaTorneo = 'SELECT s.nome, s.tipo, s.punti, s.partiteVinte, s.partitePerse, s.partitePareggiate, s.goalFatti, s.goalSubiti
                        FROM faraza.squadra as s, faraza.partecipa as p, faraza.torneo as t
                        WHERE   t.nome = "'.$_SESSION["Veditorneo"].'" AND s.ID = p.IDSquadra AND p.nomeTorneo = t.nome ORDER BY s.punti DESC';     
			$resClassificaTorneo = $_GLOBAL['pdo']->query($sqlClassificaTorneo);
    } catch (PDOException $ex) {
        echo 'SELECT Classifica non andata a buon fine ' . $ex->getMessage();
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
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $_SESSION['Veditorneo'];?> - Classifica</h3>
				</div>
				<div class="panel-body">
					<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Nome</th>
                	<th>Tipo</th>
                	<th>Punti</th>
                	<th>Vinte</th>
					<th>Perse</th>
					<th>Pareggiate</th>
					<th>GF</th>
					<th>GS</th>
					<th>DR</th>
                	</tr>
                	</thead>
                	<tbody>
<?php
        while($rowClassificaTorneo = $resClassificaTorneo->fetch()) {
            echo '<tr>';
            echo '<td> '.$rowClassificaTorneo['nome'].' </td>';
            echo '<td> '.$rowClassificaTorneo['tipo'].' </td>';
            echo '<td> '.$rowClassificaTorneo['punti'].' </td>';
            echo '<td> '.$rowClassificaTorneo['partiteVinte'].' </td>';
            echo '<td> '.$rowClassificaTorneo['partitePerse'].' </td>';
            echo '<td> '.$rowClassificaTorneo['partitePareggiate'].' </td>';
            $_SESSION['goal_fatti'] = $rowClassificaTorneo['goalFatti'];
            echo '<td> '.$_SESSION['goal_fatti'].' </td>';
            $_SESSION['goal_subiti'] = $rowClassificaTorneo['goalFatti'];
            echo '<td> '.$_SESSION['goal_subiti'].' </td>';
            echo '<td> '.($_SESSION['goal_fatti']-$_SESSION['goal_subiti']).' </td>';
            echo '</tr>';
        }
        echo '</tbody>
        	</table>';
    }
?>
				</div>
			</div>
		</div>
	</div>
    </body>
</html>
