<!-- @autor Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();

    $ID = $_SESSION["ID"];
    $partita = $_SESSION["npartita"];

    $idutnete = $_GET["id"];
    $voto = $_GET["num"];
    $commento = $_GET["comm"];
	try {
        $sql = "SELECT * FROM faraza.pagella WHERE IDGiocatore=$idutnete AND IDUtenteVotante= $ID AND IDPartitaUtente=$partita ";
        $res=$_GLOBAL['pdo']->query($sql);
        	        
        if (!$row=$res->fetch()) {
			$sql = "INSERT INTO faraza.pagella (voto , commento , IDUtenteVotante, IDGiocatore, IDPartitaUtente , visto )
					VALUES ( $voto  , '$commento' ,  $ID , $idutnete, $partita , 'false')";
			$res=$_GLOBAL['pdo']->query($sql);
        } else {
            echo '<script type="text/javascript">
                  alert("Hai già recensito questa partita");
                  window.location.assign("pagellautente.php")
                  </script>';
        }
	} catch (Exception $ex) {
		echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
		exit();
	}
    echo '<script type="text/javascript">
          alert("Pagella creata");
          window.location.assign("homeutente.php")
          </script>';
?>