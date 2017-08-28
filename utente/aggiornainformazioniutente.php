<?php
	// Alessandro Rappini, Riccardo Zandegiacomo
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
		
	// Estrazione Nome e Cognome dell'utente loggato
	$nome = $_SESSION["nome"];
	$cognome = $_SESSION["cognome"];
?>
<html>
<head>
    <title>Faraza - Opzioni</title>
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
    $ID = $_SESSION["ID"];
    $NewNome = $_POST["Nome"];
    $NewCognome = $_POST["Cognome"];
    $NewPass = $_POST["Pass"];
    $NewTell = $_POST["Tell"];
    try {
        $sql = "UPDATE faraza.utente SET nome =  '$NewNome'  , cognome =  '$NewCognome'  , password =  '$NewPass' , telefono =  '$NewTell' WHERE ID = $ID ";
        $res=$_GLOBAL['pdo']->query($sql);
    } catch (Exception $ex) {
        echo "Errore, la query non è andata a buon fine: " . $ex->getMessage();
        exit();
    }
    echo "<div class='alert alert-success' role='alert' align='middle'>Informazioni aggiornate con successo.
    	<br><br><a class='btn btn-success' href='../utente/homeutente.php' role='button'>OK</a>
    	</div>";
?>
</body>
</html>