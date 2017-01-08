<?php
    include 'functions.php';
    include 'functions_database.php';

    session_start();
    if ( $username = user_logged_in() ){
        include 'auth_sessions.php';
        set_https();
    }
    else{
        redirect_with_message('index.php', 'w', 'You must be logged in to judge a comment.');
    }

    check_enabled_cookies();

    $success = true;
    $err_msg = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            redirect_with_message("index.php", "w", "Judge action must be a post method.");
            break;
        }
        case 'POST': {
            if ( !isset($_POST['c_email']) || !isset($_POST['sign']) )
                redirect_with_message("index.php", "w", "Comment email or sign not set in judge form.");
            $c_email = $_POST['c_email'];
            $sign = $_POST['sign'];
            break;
        }
    }

    $signs = array("plus", "minus");
    if ( in_array($sign, $signs) != 1)
        redirect_with_message('index.php', 'w', 'Judge sign must be minus or plus. Please try again.');

    if ($username == $c_email)
        redirect_with_message('index.php', 'w', 'You can not judge your comment. Please judge other comments.');

    insert_judgment($username, $c_email, $sign);

    redirect_with_message('index.php', 's', 'Judgment inserted successfully.');
?>