<?php
	// @author Rappini Alessandro 
    // Tramite questo file inserisco le mail degli utenti che voglio invitare alla mia squadra
    
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
		
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<html>
<head>
    <title>Faraza - Utente</title>
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
			<a class="navbar-brand" href="../utente/homeutente.php"><?php echo $nome.' '.$cognome ?></a>
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
			        	<a href="../utente/homeutente.php">Home</a>
			        </li>
					<li class="dropdown active">
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
	    try {
		    if ($_SESSION['previousLocation'] == 'creazionePartita') {
			    $sql = "SELECT numeroMinimoGiocatori AS num FROM faraza.partitaUtente WHERE ID=".$_SESSION['partitaUtente']."";
			    $res = $_GLOBAL['pdo']->query($sql);
			    $row = $res->fetch();
			    // Determino numero minimo di giocatori
			    $_SESSION["num_min"] = $row["num"] * 2;
		    } else if ($_SESSION['previousLocation'] == 'ricercaPartita') {
				$_SESSION["num_min"] = $_SESSION['liberi'] + 1;
			} else if ($_SESSION['previousLocation'] == 'squadraTorneo') {
				//Tramite questa query trovo il numero minimo di giocatori che devono essere inseriti nella squadra
				$sql = "SELECT torneo.nome, torneo.tipo AS num
		                FROM faraza.squadra, faraza.partecipa, faraza.torneo
		                WHERE squadra.tipo='privata' AND squadra.ID= ".$_SESSION['IDsquadra']." AND squadra.ID = partecipa.IDSquadra AND partecipa.nomeTorneo = torneo.nome ";
		                
				$res = $_GLOBAL['pdo']->query($sql);
			    $row = $res->fetch();
			    
			    $_SESSION["num_min"] = $row["num"]; //numero minimo di giocatori
		    }
        } catch (PDOException $ex) {
            echo "Errore nella query non è andata a buon fine: " . $ex->getMessage();
            exit();
        }
?>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Scegli quali amici invitare</h3>
				</div>
				<div class='panel-body'>
					<form action='sendemailinvitopost.php' method='POST'>
<?php
            /* la sessione del numero minimo l'ho creata per togliermi una questy in sendemailinvitopost
               con il for stampo tante input quante sono  il numero minimo di giocatori da invitare alla partite meno uno,
               che sarebbe l'utente creante */
            for ($x = 1; $x < $_SESSION["num_min"]; $x++) {
                echo "<input class = 'form-control' type=\"text\" name=\"".$x."\"  id=\"".$x."\" value=\"email\">" ;
                echo "<br>";
            }
?>
        <button type="submit" class="btn btn-block btn-success">Invita</button>        
        </form>
    
    </body>
</html>