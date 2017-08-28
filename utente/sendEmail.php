<!-- @author Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    include_once ("../email.php");
    global $_GLOBAL;
    session_start();
    
    // Testo del messaggio
    $message = $_POST['textmail'];
    // Email
    $subject = "FARAZA - Messaggio da " .$_SESSION["nome"]. " " .$_SESSION["nognome"]. "";
    echo sendmail($_SESSION['mail_profiloFuori'], $subject, $message); // invio mail
    echo '<script type="text/javascript">
          window.location.assign("../utente/homeutente.php")
          </script>';  
?>