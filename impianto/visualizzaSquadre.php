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
        $sqlCountSq = 'SELECT count(*) as ris FROM faraza.squadra as s WHERE (ID=ANY (SELECT IDSquadra FROM faraza.partecipa WHERE nomeTorneo= "'.$_SESSION["Veditorneo"].'"))';
        $risCountSq = $_GLOBAL["pdo"]->query($sqlCountSq);
    } catch (PDOException $ex) {
        echo 'Errore nel count di visualizzazione delle squadre ' .$ex->getMessage();
    }
    $rowCountSq = $risCountSq->fetch();
    if($rowCountSq["ris"]==0) {
         echo "<div class='alert alert-danger' role='alert' align='middle'>Non ci sono ancora squadre iscritte a questo torneo.<br>Si prega di riprovare più tardi.
        <br><br><a class='btn btn-danger' href='visualizzaTornei.php' role='button'>OK</a>	
        </div>";
    } else {
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
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $_SESSION["Veditorneo"]; ?> - Squadre</h3>
			</div>
			<div class="panel-body">
				<form role="form" method='POST' action='updateClassifica.php'>
<?php
        try {
            $sql = 'SELECT s.ID, s.nome, s.tipo, s.punti, s.partiteVinte, s.partitePerse, s.partitePareggiate, s.goalFatti, s.goalSubiti'
                    . ' FROM faraza.squadra as s WHERE '
                    . '(ID=ANY (SELECT IDSquadra FROM faraza.partecipa WHERE nomeTorneo= "'.$_SESSION["Veditorneo"].'"))';
            
            $risultato = $_GLOBAL["pdo"]->query($sql);
        } catch (PDOException $ex) {
            echo 'Errore nella visualizzazione delle squadre' .$ex->getMessage();
        }
        // Variabile che serve per cambiare i nomi dinamicamente
        $_SESSION['j'] = 1; 
        // Array che salva l'id della squadra che sto stampando nella tabella. Serve per fare l'aggiornamento.
        $_SESSION['arrayid_squadra'] = array();
	
		while($row = $risultato->fetch()) {
            echo "<table class='table table-hover'>
            	<tbody>
            	<tr class='success'>";
            array_push($_SESSION['arrayid_squadra'], $row["ID"]); // aggiorniamo l'ID
            echo '<th>Nome</th>'; 
            $_SESSION["Nome_Squadra"]=$row["nome"];
            echo '<td> '.$_SESSION["Nome_Squadra"].' </td>';            
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Tipo </th>";
            $_SESSION["Tipo_s"] = $row["tipo"];
            echo '<td> '.$_SESSION["Tipo_s"].' </td>';           
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Punti </th>";
            $_SESSION["Punti_s"] = $row["punti"];             
            echo '<td>  <input class="form-control" type=text name=punti'.$_SESSION['j'].' value='.$_SESSION["Punti_s"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Partite Vinte </th>";
            $_SESSION["Partite_Vinte"] = $row["partiteVinte"];           
             echo '<td>  <input class="form-control" type=text name=partite_vinte'.$_SESSION['j'].' value='.$_SESSION["Partite_Vinte"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Partite Perse </th>";
            $_SESSION["Partite_Perse"] = $row["partitePerse"];
            echo '<td>  <input class="form-control" type=text name=partite_perse'.$_SESSION['j'].' value='.$_SESSION["Partite_Perse"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Partite Pareggiate </th>";
            $_SESSION["Partite_Pareggiate"] = $row["partitePareggiate"];
            echo '<td>  <input class="form-control" type=text name=partite_pareggiate'.$_SESSION['j'].' value='.$_SESSION["Partite_Pareggiate"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Goal Fatti </th>";
            $_SESSION["Goal_Fatti"] = $row["goalFatti"];     
            echo '<td>  <input class="form-control" type=text name=goal_fatti'.$_SESSION['j'].' value='.$_SESSION["Goal_Fatti"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th> Goal subiti </th>";
            $_SESSION["Goal_Subiti"] = $row["goalSubiti"]; 
            echo '<td>  <input class="form-control" type=text name=goal_subiti'.$_SESSION['j'].' value='.$_SESSION["Goal_Subiti"].' ></td>';
            echo "</tr>";
            
            echo "<tr>";
            echo "<th>Differenza reti</th>";
            $diff = $_SESSION["Goal_Fatti"] - $_SESSION["Goal_Subiti"];
            echo "<td>  $diff </td>";
            echo "</tr>
            	</tbody>
            	</table>";
            $_SESSION['j'] = $_SESSION['j'] + 1;
        }
?>
				<button type='submit' class="btn btn-success btn-block">Aggiorna</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $_SESSION["Veditorneo"]; ?> - Giocatori</h3>
			</div>
			<div class="panel-body">
				<form role="form" method='POST' action='updateGoalFatti.php'>
				<table class='table table-hover'>
				<thead>
	            <tr>
	            <th>Squadra</th>
	            <th>Giocatore</th>
	            <th>Goal Fatti</th>
	            </tr>
				</thead>
				<tbody>
<?php
	    try {
	        $_SESSION['r'] = 1; 
	        $_SESSION['arrayGioc'] = array();
	        for ($g = 0; $g < count($_SESSION['arrayid_squadra']); $g++) {
	            $slqGiocatore = 'SELECT u.ID , u.nome, u.cognome, g.goalFatti, g.IDGiocatore, s.nome as n
	            			FROM faraza.giocatore as g, faraza.squadra as s, faraza.utente as u
	                        WHERE g.IDGiocatore = u.ID AND g.IDSquadra = s.ID AND s.ID ='.$_SESSION['arrayid_squadra'][$g].'';
	            $risultatoGiocatori = $_GLOBAL["pdo"]->query($slqGiocatore);
		        while($rowGiocatori = $risultatoGiocatori->fetch()) {
					$_SESSION["Name"] = $rowGiocatori['nome']; 
		            $_SESSION["Surname"] = $rowGiocatori['cognome']; 
		            $_SESSION['goal'] = $rowGiocatori['goalFatti']; 
		            $_SESSION['row_count_' . $rowGiocatori['ID']] = $rowGiocatori['ID'];
		            // Creazione di variabili di sessione 'dinamiche' che permettono di creare dei link ipertestuali che rimandano all'utente selezionato
		            echo '<td>'.$rowGiocatori['n'].'</td>';
		            echo '<td><a href=profiloUtente.php?send='.$_SESSION['row_count_'.$rowGiocatori['ID']].' class="form-control">'.$_SESSION["Name"].' '.$_SESSION["Surname"].'</a></td>';
		            echo '<td><input type="text" name=goal_fatti'.$_SESSION['r'].'  class="form-control" value='.$_SESSION["goal"].'></td>';
		            echo "<tr>";
		            $_SESSION['r'] = $_SESSION['r'] + 1;
		        }
			}
	    } catch (PDOException $ex) {
			echo "Errore nella query " .$ex->getMessage();
		}
?>
					</form>
				</tbody>
				</table>
				<button type='submit' class="btn btn-success btn-block">Aggiorna goal</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
</body>
</html>