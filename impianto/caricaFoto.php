<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <!--questa tabella servirà per il caricamento dell' immagine profilo del centro-->        
        <form action="upload.php" method="post" enctype="multipart/form-data"> 
            Scegli un immagine da caricare: <br>
            "fileToUpload"
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload " name="submit"><br>
        </form>
    </body>
</html>
