<?php
	session_start();      
    include_once('connessioneDB.php');
    global $_GLOBAL;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Faraza - Benvenuto</title>
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
	<div class="container-fluid">
		<div class="row">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h1 class="panel-title" align="center">BENVENUTO IN FARAZA</h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h1 class="panel-title" align="center">LOGIN</h1>
					</div>
					<div class="panel-body">
						<form role="form" action="verificaLogin.php" method="POST">
<?php
							if (!isset($_COOKIE["email"])) {
								echo "<div class='form-group'>
								<input class='form-control' type='email' name='email_l' placeholder='Email' required>
								</div>";
							} else {
								echo "<div class='form-group'>
								<input class='form-control' type='email' name='email_l' value=".$_COOKIE['email']." placeholder='Email' required>
								</div>";
							}
							if (!isset($_COOKIE["passw"])) {
								echo "<div class='form-group'>
								<input class='form-control' type='password' name='passw_l' placeholder='Password' required>
								</div>";
							} else {
								echo "<div class='form-group'>
									<input class='form-control' type='password' name='passw_l' value=".$_COOKIE['passw']." placeholder='Password' required>
									</div>";
							}
?>
							<button class="btn btn-success btn-lg btn-block" type='submit'>Entra</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel-group" id="regCentro" role="tablist" aria-multiselectable="true">
					<div class="panel panel-success">
						<div class="panel-heading collapsed" role="tab" id="headingDue" data-toggle="collapse" href="#collapseCentro" data-parent="#regUtente" aria-expanded="false" aria-controls="collapseCentro">
							<h1 align="center" class="panel-title">REGISTRAZIONE CENTRO SPORTIVO</h1>
						</div>
						<div id="collapseCentro" class="panel-collapse collapse panel-body" role="tabpanel" aria-labelledby="headingDue"> 
							<form action="./impianto/registrazionecentro.php" method="POST"> <!-- inclusa lo script registrazione centro di antonio -->
								<div class="form-group">
									<input class="form-control" type='email' name='email_c' placeholder="Email" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='password' name='passw1_c' placeholder="Password" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='password' name='c_password2' placeholder="Ripeti password" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='nome_c' placeholder="Nome centro" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='citta' placeholder="Città" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='via' placeholder="Via" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='civico' placeholder="Civico" required>
								</div>
					            <div class="form-group">
									<input class="form-control" type='text' name='cap' placeholder="CAP" required>
					            </div>
								<div class="form-group">
									<input class="form-control" type='text' name='cellulare_c' placeholder="Telefono" required>
								</div>
								<div class="form-group">
									<div class="input-group">
										<input type="num" class="form-control" name='costo' placeholder="Costo" required>
										<div class="input-group-addon">€</div>
									</div>
									<p class="help-block">Costo della prenotazione di un campo per un'ora.</p>
								</div>
								<div class="form-group">
									<input class="form-control" type='number' name='SceltaNumeroCampi' placeholder="Numero campi" min="1" required>
								</div>
								<button class="btn btn-success btn-lg btn-block" type='submit'>Iscriviti</button>
							</form>
						</div>
					</div>
				</div>
				<div class="panel-group" id="regUtente" role="tablist" aria-multiselectable="true">
					<div class="panel panel-success">
						<div class="panel-heading collapsed" role="tab" id="headingUno"  data-toggle="collapse" href="#collapseUtente" data-parent="#regCentro" aria-expanded="true" aria-controls="collapseUtente">
							<h1 class="panel-title" align="center">REGISTRAZIONE UTENTE</h1>
						</div>
						<div id="collapseUtente" class="panel-collapse collapse panel-body" role="tabpanel" aria-labelledby="headingUno">
							<form action='./utente/registration.php' method='POST'>
								<div class="form-group">
									<input class="form-control" type='email' name='email_u' placeholder="Email" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='password' name='passw1_u' placeholder="Password" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='password' name='passw2_u' placeholder="Ripeti password" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='nome_u' placeholder="Nome" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='text' name='cognome_u' placeholder="Cognome" required>
								</div>
								<div class="form-group">
									<input class="form-control" type='tel' name='cellulare_u' placeholder="Telefono" required>
								</div>
								<button type='submit' class="btn btn-success btn-lg btn-block">Iscriviti</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>