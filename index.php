<?php
    include 'functions.php';
    include 'functions_database.php';
    include 'functions_messages.php';

    session_start();
    if ( $username = user_logged_in() ){
        include 'auth_sessions.php';
        set_https();
    }
    else{
        unset_https();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shares Manager</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="bootstrap/html5shiv.min.js"></script>
    <script type="text/javascript" src="bootstrap/respond.min.js"></script>
    <![endif]-->

    <link href="z_shares_style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="general_functions.js"></script>
    <script type="text/javascript" src="z_shares_functions.js"></script>
</head>

<body>

    <?php
        include 'navbar.php';
        include 'no_script_messages.html';
        manage_messages();
    ?>

    <div class="col-lg-2" id="left-panel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if ($username){?>
                    Your Account
                <?php }else{?>
                    Log in or Register
                <?php }?>
            </div>
            <div class="panel-body">
                <?php
                    if ( !$username ) {
                ?>
                    <form method="get" action="auth_login.php" class="navbar-form navbar-left">
                        <a href="auth_login.php">
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login
                            </button>
                        </a>
                    </form>
                <?php
                    }
                    else{
                ?>
                    <form class="navbar-form navbar-left">
                        <a href="auth_logout.php">
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                Logout
                            </button>
                        </a>
                    </form>
                <?php
                    }
                ?>
            </div>

            <?php if ($username) {?>
            <ul class="list-group">
                <li class="list-group-item">
                    Username: <?php echo $username;?>
                </li>
            </ul>
            <?php }?>

        </div>
        </div>
    </div>

    <div class="col-lg-10" id="right-panels">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Object comments list</h3>
            </div>

            <div class="panel-body">
                Average points: <?php echo get_points_avg() ?>
            </div>
            <table class="table">
                <tr>
                    <th>Comment</th>
                    <th>Points</th>
                    <th>Appreciation</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                    // comments list
                    $rows = get_comments();
                    foreach ($rows as $row){
                        echo "<tr>";
                        echo "<td>".$row['c_text']."</td>";
                        echo "<td>".$row['c_points']."</td>";
                        echo "<td>".get_comment_judge_summary($row['email'])."</td>";
                        if (! $username){
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                        }
                        else if ( $username != $row['email']) {
                ?>
                            <td>
                                <form method="post" action="judge.php">
                                    <input hidden value="plus" name="sign">
                                    <button type="submit" name="c_email" value="<?php echo $row['email'] ?>"
                                            class="btn btn-default">
                                        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="post" action="judge.php">
                                    <input hidden value="minus" name="sign">
                                    <button type="submit" name="c_email" value="<?php echo $row['email'] ?>"
                                            class="btn btn-default">
                                        <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </td>
                            <td></td>
                <?php
                        }
                        else {
                ?>
                            <td></td>
                            <td></td>
                            <td>
                                <form method='post' action='remove.php'>
                                    <button type="submit"  class="btn btn-default">
                                        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </td>
                <?php

                        }
                        echo "</tr>";
                    }
                ?>
            </table>

        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Insert comment</h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">

                    <?php
                        if ($username) {
                    ?>
                        <form method="post" action="insert.php">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Comment</span>
                                <input type="text" name="comment" placeholder="Your comment"
                                       class="form-control" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Points</span>
                                <input type="number" min="0" max="5" step="1" value="0" name="points"
                                       class="form-control" aria-describedby="basic-addon1">
                                <br>
                            </div>
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                            </button>
                        </form>
                    <?php
                        }else{
                    ?>
                        <div class="alert alert-info" role="alert">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            To insert a comment or make a judgment, please log in or register.
                        </div>
                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        if (navigator.cookieEnabled == false) {
            // preventing site usage
            removeElementById('left-panel');
            removeElementById('right-panels');
            printCookieDisabledMessage();
        }
    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="bootstrap/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>