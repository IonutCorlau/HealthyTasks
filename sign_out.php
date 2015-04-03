

<?php

    session_start();
    $_SESSION = array();
    
    session_destroy();
    session_unset();
    
    header("Location: sign_in.php");
    exit();

?>