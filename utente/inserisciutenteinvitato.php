<!-- 
@author Rappini Alessandro 
In questo file inseriamo nel DB l'utente invitato alla partita privata che ha deciso
di partecipare
-->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();
    
    try {
        // Controllo di una possibile registazioen gia' avvenuta
        echo $sql =  "SELECT IDGiocatore FROM faraza.giocatore WHERE IDGiocatore='".$_SESSION["IDR"]."' AND IDSquadra='".$_SESSION["IDsquadra"]."' ";        
                $result = $_GLOBAL['pdo']->query($sql);
		$esiste = $result->fetch();
	    if($esiste['IDGiocatore'] == null) {
            // Query che inserisce l'utente invitato nel caso in cui non si sia ancora registrato
            $sql = "INSERT INTO faraza.giocatore (IDGiocatore, IDSquadra)           
                    VALUES (".$_SESSION["IDR"].", ".$_SESSION["IDsquadra"].")";
                    $res = $_GLOBAL['pdo']->query($sql);
			echo '<script type="text/javascript">
                    alert("Iscrizione avvenuta!");
                    window.location.assign("../index.php")
                    </script>';
	    } else {
		    echo '<script type="text/javascript">
	               alert("Ti sei gia iscritto a questa partita");
	               window.location.assign("../index.php")
	               </script>';
	    }
	} catch (Exception $ex) {
		echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
		exit();
	}
?>	