<!-- @autor Rappini Alessandro -->
<?php
    //apro la sessione
    session_start();

    //distruggo la sessione
    session_destroy();

    echo '<script type="text/javascript">
          alert("Alla prossima");
          window.location.assign("../index.php")
          </script>';
?>