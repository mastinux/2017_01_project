<?php
    include 'functions.php';
    include 'functions_database.php';

    session_start();
    if ( $username = user_logged_in() ){
        include 'auth_sessions.php';
        set_https();
    }
    else{
        redirect_with_message('index.php', 'w', 'You must be logged in to insert a comment.');
    }

    check_enabled_cookies();

    $success = true;
    $err_msg = "";

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            redirect_with_message("index.php", "w", "Insert comment must be a post method.");
            break;
        }
        case 'POST': {
            if ( !isset($_POST['comment']) || !isset($_POST['points']) )
                redirect_with_message("index.php", "w", "Comment or points not set in form.");
            $comment = $_POST['comment'];
            $points = $_POST['points'];
            break;
        }
    }

    if (strlen($comment) == 0)
        redirect_with_message('index.php', 'w', 'Comment not inserted. Please enter it.');

    if ($points < 0 or $points > 5)
        redirect_with_message('index.php', 'w', 'Points must be between 0 and 5. Please enter a proper value.');

    insert_comment($username, $comment, $points);

    redirect_with_message("index.php", "s", "Comment inserted successfully.")
?>