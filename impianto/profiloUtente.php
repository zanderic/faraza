<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	include_once('../email.php');
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Profilo Utente</title>
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
	// Qui richiamiamo il parametro utilizzato in visualizzaSquadre.php (riga 144) 
	$_SESSION['IDUtenteScelto'] = $_GET['send']; 
	
	try {
		// visualizzazione di tutte le informazioni dell'utente
		$sqlProfilo = 'SELECT * FROM faraza.utente WHERE ID= '.$_SESSION['IDUtenteScelto'].''; 
		$res=$_GLOBAL['pdo']->query($sqlProfilo);
	    
	    $sqlCountVoto = 'SELECT SUM(p.voto) as v
	                    FROM utente as u , pagella as p , partitaUtente as pu , prenotazione as pr
	                    WHERE u.ID = p.IDUtenteVotante AND p.IDPartitaUtente = pu.ID AND pu.ID= pr.ID AND p.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
	                            
	    $sqlCountVoto2 = 'SELECT SUM(ppt.voto) as vt
	                    FROM utente as u, pagellaPartitaTorneo as ppt , partitaTorneo as pt, prenotazione as p
	                    WHERE u.ID = ppt.IDUtenteVotante AND ppt.IDPartitaTorneo = pt.ID AND pt.ID= p.ID AND ppt.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
	    
	    // Visualizzazione dell'immagine profilo dell' utente
	    $sqlProfilePicture = 'SELECT path1 FROM faraza.utente WHERE ID='.$_SESSION['IDUtenteScelto'].'';
	    $resProfilePicture = $_GLOBAL['pdo']->query($sqlProfilePicture);
	    $resCountVoto = $_GLOBAL['pdo']->query($sqlCountVoto);
	    $resCountVoto2 = $_GLOBAL['pdo']->query($sqlCountVoto2);
	} catch (Exception $ex) {
	    echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
	    exit();
	}
	
	$rowProfilePicture = $resProfilePicture->fetch();
	if($rowProfilePicture["path1"] == "") {
		$_SESSION["percorso_path"] = "../foto/default.jpg";
	} else {
		$_SESSION["percorso_path"] = $rowProfilePicture["path1"];
	}
	$rowProfilo = $res->fetch();
	if($rowProfilo['ID']) {
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
			<th>Email</th>";
			$_SESSION['mail_profilo_utente'] = $rowProfilo['email'];
		echo "<td>".$_SESSION['mail_profilo_utente']."</td>
			</tr>
			<tr>
			<th>Bidoni</th>
			<td><span style='color:#AFA; text-align:center;'>
				<form class='form-inline' method='POST' action='updateBidoni.php'>
				<input class='form-control' type='number' name='pt_bonus' value=".$rowProfilo['bidoni'].">
				<button type='submit' id='esci' name='Aggiorna' class='btn btn-success'>Aggiorna</button></span>
				</form>
			</td>
			</tr>
			<tr>
			<th>Telefono</th>
			<td>".$rowProfilo['telefono']."</td>
			</tr>";
	}
	else if($rowProfilo['ID']=='')
	{
	    echo "<div class='alert alert-success' role='alert' align='middle'>ERRORE! Utente non disponibile
	    <br><br><a class='btn btn-success' href='visualizzaTornei.php' role='button'>OK</a>	
	    </div>";
	    die(); // Non prosegue con il codice;
	}
?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 align="center" class="panel-title">Tornei</h3>
				</div>
				<div class="panel-body">
<?php
	
	$rowCountVoto = $resCountVoto ->fetch();
	$rowCountVoto2 = $resCountVoto2 ->fetch();
	    if($rowCountVoto['v'])
	    {
	        //$votofinale = (+$rowCountVoto2['vt'])/2;
	        echo "<table class='table table-hover'>
			<tr>
			<th>Email</th>
	        <tr>
	        <th> Voto medio partite </th>
	        <th> ' . $rowCountVoto['v']/2 . ' </th>
	        </tr>";
	    }
	    if($rowCountVoto2['vt'])
	    {
	        echo "<tr>";
	        echo '<th> Voto medio partite torneo </th>';
	        echo '<th> ' . $rowCountVoto2['vt']/2 . ' </th>';
	        echo "</tr>";
	        echo "<tr>";
	        echo '<th> Media Totale </th>';
	        echo '<th> ' . ($rowCountVoto['v'] + $rowCountVoto2['vt'])/2 . ' </th>';
	        echo "</tr>";
	    }
	    echo "</table></div><br><br>";
	    
	    // query che vede tutti i tornei nel quale un utente è iscritto 
	    // con quale squadra e con quanti goal;                    
	    try
	    {
	        $sqlInfoTorneo = 'SELECT t.nome as nt ,s.nome as ns , g.goalFatti as gf  
	                          FROM faraza.utente as u, faraza.giocatore as g, faraza.squadra as s, faraza.partecipa as p, faraza. torneo as t 
	                          WHERE u.ID = g.IDGiocatore AND g.IDSquadra=s.ID AND s.ID=p.IDSquadra AND p.nomeTorneo = t.nome AND u.ID = '.$_SESSION['IDUtenteScelto'].'';
	        $resInfoTorneo=$_GLOBAL['pdo']->query($sqlInfoTorneo);
	    } catch (Exception $ex) {
	       echo "Errore, nella ricerca dei tornei dell'utente " . $ex->getMessage();
	    }
	     echo '"<div style=text-align:center><h3>Tornei</h3><div>';
	    echo "<table border='1' style=width:100%>";
	    echo "<tr>  <th>Nome Torneo </th> "
	            . "<th>Squadra </th>"
	            . " <th> Goal Fatti </th>"
	        . " </tr>";
	    while($rowInfoTorneo = $resInfoTorneo->fetch())
	    {
	        echo '<tr>';
	        echo '<td>'.$rowInfoTorneo['nt'].'</td>';
	        
	        echo '<td>'.$rowInfoTorneo['ns'].'</td>';
	       
	        echo '<td>'.$rowInfoTorneo['gf'].'</td>';
	        echo '</tr>';
	    }
	     echo "</table>";
	    
	    //Pagella 
	    echo '"<div style=text-align:center><h3>Pagelle utente</h3><div>';
	
	     try{
	        $sqlProfiloPagella = 'SELECT p.voto , p.commento , pr.dataPrenotazione , u.nome , u.cognome
	                            FROM utente as u , pagella as p , partitaUtente as pu , prenotazione as pr
	                            WHERE u.ID = p.IDUtenteVotante AND p.IDPartitaUtente = pu.ID AND pu.ID= pr.ID AND p.IDGiocatore='.$_SESSION['IDUtenteScelto'].'
	                            UNION
	                            SELECT ppt.voto, ppt.commento, p.dataPrenotazione, u.nome, u.cognome
	                            FROM utente as u, pagellaPartitaTorneo as ppt , partitaTorneo as pt, prenotazione as p
	                            WHERE u.ID = ppt.IDUtenteVotante AND ppt.IDPartitaTorneo = pt.ID AND pt.ID= p.ID AND ppt.IDGiocatore='.$_SESSION['IDUtenteScelto'].'';
	        $resProfiloPagella=$_GLOBAL['pdo']->query($sqlProfiloPagella);
	        // questa query serve per vedere il voto medio dell'utente                        
	               
	        
	    } catch (Exception $ex) {
	        echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
	        exit();
	    }
	    
	    echo "<table border='1' style=width:100%>";
	    echo "<tr>  <th>Voto </th> "
	            . "<th>Commento </th>"
	            . " <th> Data partita </th>"
	            . " <th> Utente votante </th>"
	        . " </tr>";
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
	    echo "</table>";

            ?>
            <hr>
            <div style=text-align:center>
            <form action="" method="POST">
            <br><strong><label type="textmail"> CONTATTA L'UTENTE</label></strong><br>
            <br><input  type=text name=oggetto placeholder="Oggetto"></br>
            <br><textarea id="text" name="textmail" id="textarea" cols="45" rows="5" required="" placeholder="Scrivi una mail"></textarea></br>
            <br><input id="button_id" type="submit" name="action" value="Invia email"> </br>
             </form> 
            
            </hr>
                <?php 
                // solo se non è null $_POST[action]
                // cioè solo se premo il bottne...invierò la mail
                if( isset($_POST['action']) )
                {
                   $_SESSION['object'] = $_POST['oggetto'];
                   $_SESSION['message'] = $_POST['textmail'];
                   echo sendmail($_SESSION['mail_profilo_utente'], $_SESSION['object'], $_SESSION['message']);
                }
                ?>

                </br>
            
        </div>   
    </body>
</html>		