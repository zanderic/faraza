<!-- @author Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();
    session_unset();

    $_SESSION['IDsquadra'] = $_GET["IDsquadra"]; // SESSION ID squadra (torneo) 
    $_SESSION["IDcreante"] =  $_GET["IDcreante"]; // SESSION ID utente creante della squadra (torneo)
    $_SESSION['tipo'] = $_GET['tipo']; // SESSION tipo di percorso che faccio (info interna) (torneo - partita utente) corrisponde a SESSION[previousLocation]
    $_SESSION['prenotazione'] = $_GET['prenotazione']; // SESSION ID prenotazione (partita utente)
    
    if(isset($_COOKIE["email"]) && isset($_COOKIE["passw"])) {
        // La sessione case mi dice se l'utente si e' gia loggato oppure no
        $_SESSION["case"] = "a";
        if ($_SESSION['tipo'] == 'squadraTorneo') {
			echo '<script type="text/javascript">
				window.location.assign("../utente/dettagliregistrazione.php")
				</script>';
        } else if ($_SESSION['tipo'] == 'creazionePartita' || $_SESSION['tipo'] == 'ricercaPartita') {
			echo '<script type="text/javascript">
				window.location.assign("../partita/dettagliMatch.php")
				</script>';
        }
    }
?>
<html>  
    <head>
    </head>
    <body>
        <p align="center">Ti hanno invitato a partecipare a una partita chiusa, inserisci le tue credenziali per conoscere tutti i dettagli</p>
        <form method="POST" action="dettagliregistrazione.php">
            <p>Email</p>
            <input type="text" name="mail">
            <p>Password</p>
            <input type="password" name="password">
            <button>Accedi</button>
        </form>
    </body>
</html>

