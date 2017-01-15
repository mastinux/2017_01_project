<?php
    include 'functions.php';

    if ( !isset($_COOKIE['test']) )
        redirect_with_message("index.php", "w", "Cookies disabled, to use our site you have to enable them.");
    else
        redirect_with_message("index.php", "i", "Welcome.");
?>