<!DOCTYPE html>
<!--
author Antonio Faienza
Questa classe visutalizzerà quelle che sono le informazioni dell' utente che visita il profilo. 
NOTA: in questo script a differenza degli altri dove ogni script html faceva riferimento a uno script php definito in un
un altro file, presenta due blocchi: un blocco php e uno html. Il file html questa volta richiama il blocco
php che si trova nello stesso file.
Da notare che in questo file il pulsante aggiorna è legato al file php UpdateInfo.php che sovrascrive tutti i valori 
presenti. Nel caso il valore sia sempre lo stesso, allora lo sovrascrive con il valore stesso.
-->
<?php 
include_once ("../connessioneDB.php");
               global $_GLOBAL;
               session_start();
?>
<html>
    <head>
       
        <title>Faraza - Informazioni Centro</title>
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
        <nav class="navbar navbar-default">
		<div class="container-fluid">
                    <a class="navbar-brand" href="homeImpiantoSportivo.php"><?php echo $_SESSION["Nome_centro"] ?></a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
			        <li>
                                    <a href="homeImpiantoSportivo.php">Home</a>
			        </li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Prenotazioni e Campi<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="campo.php">Visualizza campi</a></li>
							<li><a href="prenotazioniPartiteSingole.php">Prenotazioni Utente/Privata</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tornei<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="creaTorneoForm.php">Crea Tornei </a></li>
                                                    <li><a href="visualizzaTornei.php">Visualizza Tornei</a></li>
			            </ul>
					</li>
					<li class="dropdown">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pagelle<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="pagellePartiteUtente.php">Pagelle Utente</a></li>
                                                    <li><a href="pagellePartiteTorneo.php">Pagelle Torneo</a></li>
						</ul>
					</li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
				    <li class="dropdown active">
					    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Opzioni<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
                                                    <li><a href="visualizzaInfo.php">Visualizza Informazioni</a></li>
							<!-- <li><a href="../utente/caricaimmagine.php">Aggiorna foto</a></li> -->
							<li class="divider"></li>
                                                        <li><a href="cancellaDaPiattaformaForm.php">Cancellati da Faraza</a></li>
						</ul>
					</li>
				    <li><a href="../logout.php">Logout</a></li>
			    </ul>
			</div>
		</div>
	</nav>
           <p> 
         
        <?php
            try {

                $sql = 'SELECT nomeCentro, email, password, costoOrario, citta, via, civico, cap, telefono'
                        . ' FROM `faraza`.`impiantoSportivo` '
                        . 'WHERE (ID= "' . $_SESSION["ID_Centro"] . '")';

                $result = $_GLOBAL["pdo"]->query($sql);
            } catch (PDOException $ex) {
                echo "Codice errore: " . ex . getmessage();
                //echo "errore, i valori immessi, sono già stati inseriti.";
                exit();
            }
            // stampo i risultati ottenuti
            while ($row = $result->fetch()) {
                // salvo il risultato della query in variabili di sessioni che verranno richiamate nel file html 
                //sottostante
                $_SESSION["Nome"] = $row['nomeCentro'];
                $_SESSION["mail"] = $row['email'];
                $_SESSION["pass"] = $row['password'];
                $_SESSION["costo"] = $row['costoOrario'];
                $_SESSION["city"] = $row['citta'];
                $_SESSION["street"] = $row['via'];
                $_SESSION["civi"] = $row['civico'];
                $_SESSION["cap"] = $row['cap'];
                $_SESSION["cel"] = $row['telefono'];
            }
        ?>


        <div class="container"> 
         <div class="col-md-offset-4 col-md-3">
         <h1> Informazioni sul centro: </h1>
         <form role="form" action="updateInfo.php"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
       
           <div class="form-group"> 
            <label for="text">Nome Centro:</label>
            <input type="text" name="NuovoNome" class="form-control"  value="<?php echo $_SESSION["Nome"]?>">
            </div>
             <div class="form-group"> 
            <label for="email">Email: </label>
            <input  type='email' name='NuovaMail' class="form-control" value="<?php echo $_SESSION["mail"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="number">Password: </label>
             <input  type='text' name='NuovaPass' class="form-control" value="<?php echo $_SESSION["pass"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="number">Costo Orario </label>
             <input  type='number' name='NuovoCosto' class="form-control" value="<?php echo $_SESSION["costo"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="text">Città </label>
             <input  type='text' name='NuovaCitta' class="form-control" value="<?php echo $_SESSION["city"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="text">Via </label>
             <input  type='text' name='NuovaVia' class="form-control" value="<?php echo $_SESSION["street"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="number">Civico </label>
             <input  type='number' name='NuovoCivico' class="form-control" value="<?php echo $_SESSION["civi"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="text">Cap </label>
             <td> <input  type='text' name='NuovoCap' class="form-control" value="<?php echo $_SESSION["cap"]?>" ></td>
            </div>
             <div class="form-group"> 
            <label for="number">Telefono </label>
            <input  type='text' name='NuovoTelefono' class="form-control" value="<?php echo $_SESSION["cel"]?>" ></td>
            </div>
            <input id='submit_u' type='submit' value='Aggiorna' size='25' value="AggiornaValore" ></tr>
        </form>
         </div>
        </div>
    </body>
</html>
