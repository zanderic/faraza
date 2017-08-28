<!-- @autor Rappini Alessandro -->
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    include_once ("../email.php");
    session_start(); // deve essere la prima cosa nella pagina, aprire la sessione
    
    $_SESSION["nome"] = $_POST["nome_u"];
    $_SESSION["cognome"] = $_POST["cognome_u"];
    $_SESSION["mail"] = $_POST["email_u"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION username
    $_SESSION["pass"] = $_POST["passw1_u"]; // con questo associo il parametro username che mi è stato passato dal form alla variabile SESSION password
    $_SESSION["telefono"] = $_POST["cellulare_u"];

    //include("Email.php"); // includo il file di connessione al database
    $emailDaInserire = $_POST["email_u"];
    
    // controllo mail
    try
    {
        // impianto
        $stmt = $_GLOBAL['pdo']->prepare('CALL verificaMailImpianto( ? ,@booleanv)'); // preparo la chimata alla store procedure
        $stmt->bindParam(1, $_SESSION['mail'], $_GLOBAL['pdo']::PARAM_STR, 4000); // definisco i parametri;   
        // utente    
        $stmt2 = $_GLOBAL['pdo']->prepare('CALL verificaMailUtente( ? ,@booleant)'); // preparo la chimata alla store procedure
        $stmt2->bindParam(1, $_SESSION['mail'], $_GLOBAL['pdo']::PARAM_STR, 4000);     
        // call the stored procedure impianto
        $stmt->execute();
        $result = $_GLOBAL['pdo']->query('SELECT @booleanv');
        $row = $result->fetch();
        
        // call the stored procedure utente
        $stmt2->execute();
        $result2 = $_GLOBAL['pdo']->query('SELECT @booleant');
        $row2 = $result2->fetch();
        
    } catch (PDOException $ex) {
        echo "Qualcosa nella STORE PROCEDURE verificaMail non è andato" .$ex->getMessage();
    }
    $outputbooleano = $row['@booleanv'];
    $outputbooleano2 = $row2['@booleant'];
    if(($outputbooleano==TRUE) OR ($outputbooleano2==TRUE))
    { 
        $_SESSION['variabileErrore'] = "Mail già in uso";
        echo '<script type="text/javascript">
              alert("Email già in uso riprovare");
               window.location.assign("../index.php")
              </script>';
        exit();
    } else {
		if ($_SESSION["pass"] == $_POST["passw2_u"]) {
			try {
                $sql = "INSERT INTO faraza.utente (nome, cognome, email, password, telefono) VALUES ('" . $_SESSION["nome"] . "','" . $_SESSION["cognome"] . "','" . $_SESSION["mail"] . "','" . $_SESSION["pass"] . "' ,'" . $_SESSION["telefono"] . "')";
                $query_registrazione = $_GLOBAL['pdo']->query($sql);
                
                // Estrazione dell'ID dell'ultima partita Utente CHIUSA inserita
				$max = "SELECT MAX(ID) AS ID FROM faraza.utente";
				$result = $_GLOBAL['pdo']->query($max);
				$row = $result->fetch();
				if ($row['ID']) {
					$_SESSION['ID'] = $row['ID']; // SESSION ID ultimo utente inserito
				}
            } catch (Exception $ex) {
                echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
                exit();
            }
            if (isset($query_registrazione)) { // se la reg è andata a buon fine
                //email
                $subject = "FARAZA - Registrazione";
				$messaggio = "La registrazione effettuata su FARAZA e' avvenuta con successo, le sue credenziali sono:<br><br>Email: ".$_SESSION['mail']."<br>Password: ".$_SESSION["pass"];
                echo sendmail($_SESSION['mail'], $subject, $messaggio); // invio mail
                
                echo '<script type="text/javascript">
                  window.location.assign("caricaimmagine.php")
                  </script>';
            } else {
                echo "Non ti sei registrato con successo"; // altrimenti esce la scritta a video questa stringa
            }
		} else {
	        echo '<script type="text/javascript">
	              alert("Password diverse");
	              window.location.assign("../index.php")
	              </script>';
		}
	}	
?>
