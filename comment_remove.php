<?php
    include 'functions.php';
    include 'functions_database.php';

    session_start();
    if ( $username = user_logged_in() ){
        include 'auth_sessions.php';
        set_https();
    }
    else{
        redirect_with_message('index.php', 'w', 'You must be logged in to remove your comment.');
    }

    check_enabled_cookies();

    $success = true;
    $err_msg = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            redirect_with_message("index.php", "w", "Remove comment must be a post method.");
            break;
        }
        case 'POST': {
            break;
        }
    }

    remove_comment($username);

    redirect_with_message("index.php", "s", "Comment removed successfully.")
?>