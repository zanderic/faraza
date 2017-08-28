<!DOCTYPE html>
<html>
    <head>
		<title>Faraza - Uscita</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		
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
	session_start();
    session_destroy();
    echo "<div class='alert alert-success' role='alert' align='middle'>Grazie, alla prossima!
    	<br><br><a class='btn btn-success' href='index.php' role='button'>OK</a>	
    	</div>";
?>
    </body>
</html>
