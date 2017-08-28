<!-- @autor Rappini Alessandro -->
<?php
            //popup
            echo "<script language=\"javascript\">";
            echo "var answer = confirm(\"Sei sicuro di volerti eliminare da questa piattaforma?\");";
            echo "if(answer){ (window.location='eliminaprofilodef.php?choice=PENDING'); } else { (window.location='homeutente.php?choice=PENDING'); }";
            echo "</script>";



?>