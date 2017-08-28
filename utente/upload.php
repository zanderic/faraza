<?php

    include_once ("../connessioneDB.php");
    global $_GLOBAL;
    session_start();
    
    $target_dir = "../foto/"; // specifica la directory dove il file deve essere allocato
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // specifica il percorso del file dove deve essere caricato

    $uploadOk = 1;
    $direzionaImmaginesql = 0; // variabile settata a zero, quindi ancora non inserita
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // detiene l'estensione del file
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo '<script type="text/javascript">
                  alert("ERRORE A");
                  window.location.assign("homeutente.php")
                  </script>';
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0; 
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<script type="text/javascript">
                  alert("ERRORE B");
                  window.location.assign("homeutente.php")
                  </script>';
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
       echo '<script type="text/javascript">
              window.location.assign("homeutente.php")
              </script>';
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo '<script type="text/javascript">
                  alert("Caricamento riuscito");
                  window.location.assign("homeutente.php")
                  </script>';
        } 
    }
  
    // inseriamo il path all'interno del database
    try {
        $sql = 'UPDATE faraza.utente SET path1= "' . $target_file . '" WHERE `ID`= "' . $_SESSION["ID"] . '" ';
        $resUpdate = $_GLOBAL['pdo']->exec($sql);
        exit();
    } catch (PDOException $ex) {
        echo '<script type="text/javascript">
                  alert("ERRORE E");
                  window.location.assign("homeutente.php")
                  </script>';
    }
    echo '<script type="text/javascript">
                  alert("Caricamento riuscito");
                  window.location.assign("homeutente.php")
                  </script>';

 
?>