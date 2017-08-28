<!-- 
    @author Rappini Alessandro 
    In questo file tramite il nome , il tipo e il nome del torneo precedentemente aquisiti inserisco i valori all interno del DB.
    Le operazioni sono:
    - Inserisco nel DB la squadra che voglio creare
    - Trovo l'ID della squadra appena creata
    - Setto la squadra appena creata con il torneo che vuole giocare
    - Setto l'utente create della squadra come giocatore
    - Se la squadra è pubblica terminata l'iscizzione del caso sia chiusa si passa a inviare la mail agli utenti che ne vogliono partecipare
-->
<?php
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
<?php
    $_SESSION['previousLocation'] = 'squadraTorneo';
        try {
            $nomeTorneo  = $_POST["nometorneo"];   

	        // Controllo se l'utente e' iscritto a una partita nel torneo, nel caso non puo' crearne un'altra
            $sql = "SELECT *
                	FROM giocatore , squadra , partecipa , torneo
					WHERE giocatore.IDSquadra = squadra.ID AND squadra.ID = partecipa.IDSquadra AND partecipa.nomeTorneo = torneo.nome  
                    AND giocatore.IDGiocatore = '".$_SESSION["ID"]."' AND torneo.nome='$nomeTorneo'";
            $res = $_GLOBAL['pdo']->query($sql);

	        if ($res->fetch()) {
	           echo "<div class='alert alert-danger' role='alert' align='middle'>Sei gia' iscritto ad una squadra che partecipa allo stesso torneo, scegli un'altro torneo per continuare.
			   		<br><br><a class='btn btn-danger' href='creasquadra.php' role='button'>OK</a>
			   		</div>";
	        } else {
	            // Controllo se ci sono altre squadre con lo stesso nome all'interno dello stesso torneo	            
                $sql = "SELECT squadra.nome
                    	FROM faraza.squadra , faraza.partecipa , faraza.torneo
						WHERE squadra.ID = partecipa.IDSquadra AND partecipa.nomeTorneo = torneo.nome AND torneo.nome = '$nomeTorneo' AND squadra.nome = '" . $_POST["nome"] . "'";
                $res = $_GLOBAL['pdo']->query($sql);
                
	            if ($res->fetch()) {
	                echo "<div class='alert alert-danger' role='alert' align='middle'>Una squadra con lo stesso nome e' gia' iscritta al torneo, scegliere un altro nome.
						<br><br><a class='btn btn-danger' href='creasquadra.php' role='button'>OK</a>	
						</div>";
	            } else {
	                // Inserisco nel DB la squadra che ho appena creato e gli setto il tipo
	                $sql =  "INSERT INTO faraza.squadra (nome, tipo)
	                        VALUES ('" . $_POST["nome"] . "','" . $_POST["tipo"] . "')";
	                $res=$_GLOBAL['pdo']->query($sql);
	           
					// Prendo tutte le squdre e inverto il loro ordine in modo da prende l'id della squadra che ho appena iscritto
	                $sql =  "SELECT * 
	                         FROM faraza.squadra 
	                         ORDER BY ID desc ";
	                $res=$_GLOBAL['pdo']->query($sql); 
	   
		            $arrayID = array();
		            $cont = 1;
		            while ($row = $res->fetch()) {
		                $arrayID[$cont] = $row; // Inserisco tutte le squadre di in ordine inverso
		                $cont ++;
		            }
		            $_SESSION["IDsquadra"] = $arrayID[1]['ID']; // trovo l'id della squadra tramite l'ultima che ho inserito
		            // mi serve per ricordarmi l'id della squadra che ho appena inserito
		            $nomeTorneo  = $_POST["nometorneo"];
		
		            //ora aggancio la squadra che ho appena inserito con il torneo che ha scelto
		            $sql = "INSERT INTO faraza.partecipa (`IDSquadra`, `nomeTorneo`) VALUES ('".$_SESSION["IDsquadra"]."'  , '$nomeTorneo') ";
		            $res = $_GLOBAL['pdo']->query($sql);
		
		            //prima di uscire setto il creante della squadra come giocatore di essa
	                $sql = "INSERT INTO faraza.giocatore (IDGiocatore , IDSquadra )
	                         VALUES ( '" . $_SESSION["ID"] . "'  , '".$_SESSION["IDsquadra"]."' )";
	                $res = $_GLOBAL['pdo']->query($sql);
	                
	                if ($_POST['tipo'] == "pubblica") {
			            // se scelgo una squadra pubblica
						echo "<div class='alert alert-success' role='alert' align='middle'>Squadra pubblica creata correttamente!
							<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>	
							</div>";
			        } else {
			            //se scelgo una squadra privata
						echo "<div class='alert alert-success' role='alert' align='middle'>Squadra privata creata correttemante, passiamo all'invito degli amici...
							<br><br><a class='btn btn-success' href='../utente/sendemailinvito.php' role='button'>OK</a>	
							</div>";
			        }	                
				}
			}
	    } catch (Exception $ex) {
            echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
            exit();
		}
?>
</body>
</html>