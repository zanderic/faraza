<!-- @autor Rappini Alessandro -->
<H1> Crea squadra</H1>
<form action="creasquadrapost.php" method="GET"> 
    <p>
        <label for="textfield">inserisci il nome della tua nuova squadra :</label>
        <input type="text" name="nome" id="nome">
    </p>
    <p>che tipo di quadra è : 
        <select id='tipo' name='tipo'>
            <option name='pubblica' value='pubblica'>pubblica</option>
            <option name='privata' value='privata'>privata</option>

        </select>
    </p>
    <p>A quale toreno vuoi partecipare:</p>
    <p>
        <?php
        include_once ("../connessioneDB.php");
        global $_GLOBAL;
        session_start();
        $CDate = date('Y-m-d');

        try             
        {
            $sql =("SELECT * 
                    FROM faraza.torneo , faraza.impiantoSportivo  
                    WHERE torneo.IDImpiantoSportivo=impiantoSportivo.ID AND    inizioIscrizioni  > $CDate  AND fineIscrizioni > $CDate ") or die(mysql_error())
                    OR DIE('query non riuscita'.mysql_error()); // messagio che sancisce che la query non è andata a buon fine
            $res=$_GLOBAL['pdo']->query($sql);
        } catch (Exception $ex) {
            echo "Errore, la query (SELECT) non è andata a buon fine: " . $ex->getMessage();
            exit();
        }
        
        echo "<table border='1'>";
        echo "<tr> <th>Numero</th> <th>Nome</th> <th>Impianto </th> <th>Costo</th> <th>InizioTorneo</th> <th>FineTorneo</th> <th>InizioIscizioni</th> <th>FineIscrizioni</th> </tr>";
        // keeps getting the next row until there are no more to get
        $cont = 0;
        while ($row = $res->fetch()) {
            $cont++;
            // Print out the contents of each row into a table
            echo "<tr><td>";
            echo $cont;
            echo "</td><td>";
            echo $row['nome'];
            echo "</td><td>";
            echo $row['nomeCentro'];
            echo "</td><td>";
            echo $row['costo'];
            echo "</td><td>";
            echo $row['inizioTorneo'];
            echo "</td><td>";
            echo $row['fineTorneo'];
            echo "</td><td>";
            echo $row['inizioIscrizioni'];
            echo "</td><td>";
            echo $row['fineIscrizioni'];
            echo "</td></tr>";
        }

        echo "</table>";
        ?>

    </p>
    <p>
        <input type="number" name="num" id="num">
    </p>
    <p>
        <input type="submit" name="crea" id="crea" value="Crea">
    </p>
    <p>
        <input type="button" name="esci" id="esci" value="Esci" onClick="parent.location = 'homeutente.php'">
    </p>
</form>