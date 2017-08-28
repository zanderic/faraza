<?php
	// Alessandro Rappini, Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	include_once('../email.php');
	global $_GLOBAL;
	session_start();
		
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<html>
<head>
    <title>Faraza - Cerca</title>
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
			        <li>
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
					<li class="dropdown active">
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
    // Richiamiamo il parametro utilizzato in visualizzaSquadre.php (riga 144)
    $_SESSION['IDUtenteScelto'] = $_GET["num"]; 
    try {
        // Visualizzazione dell'immagine profilo dell' utente
        $sqlProfilePicture = 'SELECT path1 FROM faraza.utente WHERE ID='.$_SESSION['IDUtenteScelto'].'';
        $resProfilePicture=$_GLOBAL['pdo']->query($sqlProfilePicture);
        // visualizzazione di tutte le informazioni dell'utente
        $sqlProfilo = 'SELECT * FROM faraza.utente WHERE ID = '.$_SESSION['IDUtenteScelto'].'';                            
        $res=$_GLOBAL['pdo']->query($sqlProfilo);
        
        $sqlCountVoto = 'SELECT SUM(p.voto) as v
                         FROM utente as u , pagella as p , partitaUtente as pu , prenotazione as pr
                         WHERE u.ID = p.IDUtenteVotante AND p.IDPartitaUtente = pu.ID AND pu.ID= pr.ID AND p.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
                                
        $sqlCountVoto2 = 'SELECT SUM(ppt.voto) as vt
                         FROM utente as u, pagellaPartitaTorneo as ppt , partitaTorneo as pt, prenotazione as p
                         WHERE u.ID = ppt.IDUtenteVotante AND ppt.IDPartitaTorneo = pt.ID AND pt.ID= p.ID AND ppt.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
        $resCountVoto=$_GLOBAL['pdo']->query($sqlCountVoto);
        $resCountVoto2=$_GLOBAL['pdo']->query($sqlCountVoto2);
    } catch (Exception $ex) {
        echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
        exit();
    }
    
    $rowProfilePicture = $resProfilePicture->fetch();
    if($rowProfilePicture["path1"]=="") {
        $_SESSION["percorso_path"] = "../foto/default.jpg";
    } else {
        $_SESSION["percorso_path"] = $rowProfilePicture["path1"];
	}
	
	$rowProfilo = $res->fetch();
    if ($rowProfilo['ID']) {
        $_SESSION['mail_profilo_utente'] = $rowProfilo['email'];
?>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title"> <?php echo $rowProfilo['nome'].' '.$rowProfilo['cognome'] ?></h3>
				</div>
				<div class="panel-body">
					<div class="col-md-5">
						<img src = <?php echo $_SESSION["percorso_path"]; ?> class = "img-responsive img-thumbnail" alt="Profile Pic">
					</div>
					<div class="col-md-6">
<?php
					echo "<table class='table table-hover'>
						<tbody>
						<tr>
						<th>Email</th>
						<td>".$_SESSION['mail_profilo_utente']."</td>
						</tr>
						<tr>
						<th>Bidoni</th>
						<td>".$rowProfilo['bidoni']."</td>
						</tr>
						<tr>
						<th>Telefono</th>
						<td>".$rowProfilo['telefono']."</td>
						</tr>";
                } else if($rowProfilo['ID']=='') {
                    echo "<div class='alert alert-danger' role='alert' align='middle'>Errore, utente non disponibile!
                    	<br><br><a class='btn btn-danger' href='homeutente.php' role='button'>OK</a>
						</div>";
                    die();
                }
                $rowCountVoto = $resCountVoto ->fetch();
                $rowCountVoto2 = $resCountVoto2 ->fetch();
                if($rowCountVoto['v']) {
                    echo "<tr>
                    	<th>Media Partite Utente</th>
						<td> " . $rowCountVoto['v']/2 . " </td>
						</tr>";
                }
                if($rowCountVoto2['vt']) {
                    echo "<tr>
                    	<th>Media Partite Torneo</th>
						<td> " . $rowCountVoto2['vt']/2 . " </td>
						</tr>
						<tr>
						<th>Media Totale</th>
						<td>" . ($rowCountVoto['v'] + $rowCountVoto2['vt'])/2 . " </td>
						</tr>";
                }
?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Tornei giocati</h3>
				</div>
				<div class="panel-body">
<?php              
                // Query che vede tutti i tornei nel quale un utente è iscritto, con quale squadra e con quanti goal
                try {
                    $sqlInfoTorneo = 'SELECT t.nome as nt ,s.nome as ns , g.goalFatti as gf  
                                      FROM faraza.utente as u, faraza.giocatore as g, faraza.squadra as s, faraza.partecipa as p, faraza. torneo as t 
                                      WHERE u.ID = g.IDGiocatore AND g.IDSquadra=s.ID AND s.ID=p.IDSquadra AND p.nomeTorneo = t.nome AND u.ID = '.$_SESSION['IDUtenteScelto'].'';
                    $resInfoTorneo=$_GLOBAL['pdo']->query($sqlInfoTorneo);
                } catch (Exception $ex) {
                   echo "Errore, nella ricerca dei tornei dell'utente " . $ex->getMessage();
                }
                echo "<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Nome</th>
					<th>Squadra </th>
					<th>Goal Fatti</th>
                    </tr>
                    </thead>
                    <tbody>";
                while($rowInfoTorneo = $resInfoTorneo->fetch()) {
                    echo '<tr>
                    	<td>'.$rowInfoTorneo['nt'].'</td>
						<td>'.$rowInfoTorneo['ns'].'</td>
						<td>'.$rowInfoTorneo['gf'].'</td>
						</tr>';
                }
?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Pagelle ricevute</h3>
				</div>
				<div class="panel-body">
<?php
                // Pagella
                try {
                    $sqlProfiloPagella = 'SELECT p.voto , p.commento , pr.dataPrenotazione , u.nome , u.cognome
                                        FROM utente as u , pagella as p , partitaUtente as pu , prenotazione as pr
                                        WHERE u.ID = p.IDUtenteVotante AND p.IDPartitaUtente = pu.ID AND pu.ID= pr.ID AND p.IDGiocatore='.$_SESSION['IDUtenteScelto'].'
                                        UNION
                                        SELECT ppt.voto, ppt.commento, p.dataPrenotazione, u.nome, u.cognome
                                        FROM utente as u, pagellaPartitaTorneo as ppt , partitaTorneo as pt, prenotazione as p
                                        WHERE u.ID = ppt.IDUtenteVotante AND ppt.IDPartitaTorneo = pt.ID AND pt.ID= p.ID AND ppt.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
                    $resProfiloPagella=$_GLOBAL['pdo']->query($sqlProfiloPagella);
                    // Questa query serve per vedere il voto medio dell'utente                        
                } catch (Exception $ex) {
                    echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
                    exit();
                }
                echo "<table class='table table-hover'>
                	<thead>
                	<tr>
                	<th>Voto</th>
					<th>Commento</th>
					<th>Data partita</th>
					<th>Utente votante</th>
                    </tr>
                    </thead>
                    <tbody>";
                while ($rowProfiloPagella = $resProfiloPagella ->fetch()) {
                    echo "<tr><td>";
                    echo $rowProfiloPagella[0];
                    echo "</td><td>";
                    echo $rowProfiloPagella[1];
                    echo "</td><td>";
                    echo $rowProfiloPagella[2];
                    echo "</td><td>";
                    echo $rowProfiloPagella[3];
                    echo "	";
                    echo $rowProfiloPagella[4];
                    echo "</td></tr>";
                }
?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Contatta l'utente</h3>
				</div>
				<div class="panel-body">
					<form method="POST">
						<input class='form-control' type='text' name='oggetto' placeholder="Oggetto" required><br>
						<textarea class='form-control' name="textmail" rows="5" placeholder="Scrivi qualcosa" required></textarea><br>
						<button type='submit' class='btn btn-block btn-success'>Scrivi</button>
    				</form>
				</div>
<?php
                // Solo se non è null $_POST[action], cioè invierò la mail solo se premo il bottne
                $_SESSION['object'] = '';
                if (isset($_POST['oggetto'])) {
	                $_SESSION['object'] = $_POST['oggetto'];
	            }
                $_SESSION['message'] = '';
                if (isset($_POST['textmail'])) {
	                $_SESSION['message'] = $_POST['textmail'];
				}
				echo sendmail($_SESSION['mail_profilo_utente'], $_SESSION['object'], $_SESSION['message']);
?>
			</div>
		</div>
	</div>   
</body>
</html>		