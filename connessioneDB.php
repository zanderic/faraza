<?php
	// Riccardo Zandegiacomo
	try {
		// Creazione oggetto PDO
		$_GLOBAL['pdo'] = new PDO("mysql:host=localhost:3306; dbname=faraza", "root", "root");
		
		// Lancia eccezioni qualora una query non venga eseguita correttamente
		$_GLOBAL['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		// Codifica dei caeratteri 
		$_GLOBAL['pdo']->exec('SET NAMES "utf8"');
    } catch (PDOException $ex) {
		echo("Connessione non riuscita: " . $ex->getMessage());
		exit();
    }
?>