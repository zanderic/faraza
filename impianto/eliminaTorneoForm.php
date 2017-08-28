<?php
	// Antonio Faienza
	include_once ("../connessioneDB.php");
	global $_GLOBAL;
	session_start();
?>
<!DOCTYPE html>
<html>
<head>       
	<title>Faraza - Tornei</title>
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
    <!-- immagine scorrimento per bootstrap -->
</head>
<body>
<?php
    echo "<form method=POST action='eliminaTorneo.php'>";
    echo "<div class='alert alert-danger' role='alert' align='middle'>Sto per eliminare il torneo ".$_POST["Dettagli"]."<br><br>Proseguire?
    	<br><br><a class='btn btn-sm btn-danger' href='visualizzaTornei.php' role='button'>Indietro</a>
    	<button type='submit' class='btn btn-sm btn-danger'>Conferma</button>
    	</div>";
    $_SESSION["DeleteNomeTorneo"] = $_POST["Dettagli"];
    echo "</form>";
?>
</body>
</html>
