<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
        $dsn = "mysql:host=localhost;dbname=faraza";
        $user = "root";
        $password = "root";
        $pdo = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_LOCAL_INFILE=>1));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        try
        {
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/utenti.txt" INTO TABLE utente FIELDS TERMINATED BY "," (nome,cognome,email,password,telefono)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/impiantosportivo.txt" INTO TABLE impiantoSportivo FIELDS TERMINATED BY "," (nomeCentro,email,password,costoOrario,citta,via,civico,cap)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/campo.txt" INTO TABLE campo FIELDS TERMINATED BY "," (ID,IDImpiantoSportivo)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/recensione.txt" INTO TABLE recensione FIELDS TERMINATED BY "," (data,voto,commento,IDUtente,IDImpiantoSportivo)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/torneo.txt" INTO TABLE torneo FIELDS TERMINATED BY "," LINES TERMINATED BY "\r\n" (nome,IDImpiantoSportivo,tipo,Costo,inizioTorneo,fineTorneo,inizioIscrizioni,fineIscrizioni,numeroMinimoSquadre)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/squadra.txt" INTO TABLE squadra FIELDS TERMINATED BY "," LINES TERMINATED BY "\r\n" (nome,tipo)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/partecipa.txt" INTO TABLE partecipa FIELDS TERMINATED BY "," LINES TERMINATED BY "\r\n" (IDSquadra,nomeTorneo)');
            $pdo->exec('LOAD DATA LOCAL INFILE "../load/giocatore.txt" INTO TABLE giocatore FIELDS TERMINATED BY "," LINES TERMINATED BY "\r\n" (IDGiocatore,IDSquadra)');
        } catch (PDOException $ex) {
            echo 'Errore caricamento file ' . $ex->getMessage();
        }        
?>
    </body>
</html>
