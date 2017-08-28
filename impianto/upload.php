<!DOCTYPE html>
<!--
author Antonio Faienza
FONTE: http://www.w3schools.com/php/php_file_upload.asp
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Aggiorna foto</title>
    </head>
    <body>
<?php
    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();
    
    // Con questa query verifico l'immagine che voglio modificare in quale colonna si trova 
    try {
        $sqlTrovaColonna = 'SELECT path1,path2,path3 FROM faraza.impiantoSportivo WHERE ID = "'.$_SESSION["ID_Centro"].'"';
        $resColonna = $_GLOBAL["pdo"]->query($sqlTrovaColonna);
    } catch (PDOException $ex) {
		echo "Errore nell'individuazione della colonna " .$ex->getMessage();
    }
    $risultatoColonna = $resColonna->fetch();
    if($risultatoColonna["path1"] == $_POST["TendinaAggiornamento"]) { 
        // Setto il valore a null   
        try {
            echo $sqlUpdateValore = 'UPDATE faraza.impiantoSportivo SET path1 = "" WHERE ID = "' . $_SESSION["ID_Centro"] . '"';
            $resvalore = $_GLOBAL["pdo"]->query($sqlUpdateValore);
        } catch (PDOException $ex) {
            echo "Aggiornamento non andato a buon fine " . $ex->getMessage();
        } 
    } else if($risultatoColonna["path2"] == $_POST["TendinaAggiornamento"]) {
        // Setto il valore a null
        try {
            $sqlUpdateValore = 'UPDATE faraza.impiantoSportivo SET path2 = "" WHERE ID = "' . $_SESSION["ID_Centro"] . '"';
            $resvalore = $_GLOBAL["pdo"]->query($sqlUpdateValore);
        } catch (PDOException $ex) {
            echo "Aggiornamento non andato a buon fine " . $ex->getMessage();
        }
    } else if($risultatoColonna["path3"]==$_POST["TendinaAggiornamento"]) { 
        // Setto il valore a null
        try {
            $sqlUpdateValore = 'UPDATE `faraza`.`impiantoSportivo` SET path3 = "" WHERE ID = "' . $_SESSION["ID_Centro"] . '"';
            $resvalore = $_GLOBAL["pdo"]->query($sqlUpdateValore);
        } catch (PDOException $ex) {
            echo "Aggiornamento non andato a buon fine " . $ex->getMessage();
        }
    }
    
    // Directory dove il file deve essere allocato
    $target_dir = "../foto/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Percorso del file dove deve essere caricato

    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // Detiene l'estensione del file
	// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<script type="text/javascript">
                  alert("Il file da lei scelto non è un immagine..");
                  window.location.assign("homeImpiantoSportivo.php")
                  </script>';
            $uploadOk = 0;
        }
    }
	// Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        echo '<script type="text/javascript">
               window.location.assign("homeImpiantoSportivo.php")
               </script>';
    }
	// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<script type="text/javascript">
               alert("Errore - solo formato JPG, JPEG, PNG & GIF");
               window.location.assign("homeImpiantoSportivo.php")
               </script>';
        $uploadOk = 0;
    }
	// Check if $uploadOk is set to 0 by an error
    if ($uploadOk != 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo '<script type="text/javascript">
               alert("Caricamento riuscito");
               window.location.assign("homeImpiantoSportivo.php")
               </script>';
        }
    }

    // Verifico se la prima colonna è occupata
    try {
        $sqlColonna = 'SELECT path1, path2, path3 FROM faraza.impiantoSportivo WHERE ID = "'.$_SESSION["ID_Centro"].'"';
        $resColonna = $_GLOBAL['pdo']->query($sqlColonna);
    } catch (PDOException $ex) {
        echo "Errore nella select" .$ex->getMessage();
    }
    // Facciamo controlli per vedere se i percorsi delle immagini non sono settati a null, in questo caso può aggiornare l'immagine
    $rowColonna = $resColonna->fetch();
    // Controllo delle colonne relative al path 
    if($rowColonna["path1"]=="") {
	    echo $colonnaUno = 1;
	} else {
		$colonnaUno = 0;
	}
    if($rowColonna["path2"]=="") {
	    $colonnaDue = 1;
	} else {
		$colonnaDue = 0;
	}
    if($rowColonna["path3"]=="") {
	    $colonnaTre = 1;
	} else {
		$colonnaTre = 0;
	}
    
	if($colonnaUno == 1) {
		// inseriamo il path all'interno del database
		try {
		    echo $sql = 'UPDATE faraza.impiantoSportivo SET path1= "' . $target_file . '" WHERE `ID`= "' . $_SESSION["ID_Centro"] . '" ';
		    $resUpdate = $_GLOBAL['pdo']->exec($sql);
		    exit();
		} catch (PDOException $ex) {
		    echo "Inserimento path non riuscito" . $ex->getMessage();
		}
	} else if($colonnaDue == 1) {
	    // inseriamo il path all'interno del database
	    try {
	        
	        $sql = 'UPDATE faraza.impiantoSportivo SET path2= "' . $target_file . '" WHERE `ID`= "' . $_SESSION["ID_Centro"] . '" ';
	        $resUpdate = $_GLOBAL['pdo']->exec($sql);
	        exit();
	    } catch (PDOException $ex) {
	        echo "Inserimento path non riuscito" . $ex->getMessage();
	    }
	} else if($colonnaTre == 1) {
	    // inseriamo il path all'interno del database
	    try {
	        
	        $sql = 'UPDATE faraza.impiantoSportivo SET path3= "' . $target_file . '" WHERE `ID`= "' . $_SESSION["ID_Centro"] . '" ';
	        $resUpdate = $_GLOBAL['pdo']->exec($sql);
	        exit();
	    } catch (PDOException $ex) {
	        echo "Inserimento path non riuscito" . $ex->getMessage();
	    }
	} else  {
	    echo "Tutte le immagini sono state inserite";
	}
?>
    </body>
</html>
