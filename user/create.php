<?php
include "../functions.php";
if (isset($_SESSION) == false){
    session_start([
        "cookie_lifetime" => 3600,
    ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $password = "";
    $email_err = $password_err = "";

    if (empty(trim($_POST["email"]))){
        $email_err = "Empty email! How we gonna send you cats?!";
    }
    else{
        $email = $_POST["email"];
    }
    if (empty(trim($_POST["pwd"]))){
        $password_err = "Empty password! Very-very unsecure!";
    }
    elseif (is_bad_password($_POST["pwd"])){
        $password_err = "Incorrect password.";
    }
    else{
        $password = $_POST["pwd"];
    }

    if ($email_err == "" && $password_err == "") {
        if (find_user($email) != null){
            $email_err = "User already exists!";
        }
        else{
            add_user($email, $password);
            login($email);
        }
    }

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create new account</title>
        <link rel="stylesheet" href="/source/style.css">
    </head>

    <body>
    <?php
    create_header();
    ?>

    <main>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($email_err != "") {
                echo create_error_block($email_err);
            }
            if ($password_err != "") {
                echo create_error_block($password_err);
            }
        }
        ?>

        <?php
        if (isset($_SESSION["user"])){
            echo "<div class='already_logged'>You're already logged! <a href='/btcRate.php'>Check BTC rate</a></div>";
        }
        else {
            echo '<form class="login form" method="post" action="/user/create.php">' .
                '<label for="email">Email:</label>' .
                '<input type="email" name="email" id="email" placeholder="Type me your email...">' .
                '<label for="pwd">Password:</label>' .
                '<input type="password" name="pwd" id="pwd" placeholder="Type your secure password...">' .
                '<label for="policy"><input type="checkbox" id="policy" name="cats" disabled checked>' .
                'Accept for mailing photos of cute cats :3</label>' .
                '<input type="submit" value="Make me your member!">' .
                '</form>';
        }
        ?>
    </main>

    <footer>

    </footer>
    </body>
</html>