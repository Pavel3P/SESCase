<?php
include "../functions.php";
if (isset($_SESSION) == false){
    session_start([
        "cookie_lifetime" => 3600,
    ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $password = "";
    $email_err = $password_err = "";

    if (empty(trim($_POST["email"]))){
        $email_err = "Empty email! We cannot identify you.";
    }
    else{
        $email = $_POST["email"];
    }

    if (empty(trim($_POST["pwd"]))){
        $password_err = "Empty password! You shall not pass.";
    }
    elseif (is_bad_password($_POST["pwd"])){
        $password_err = "Incorrect password.";
    }
    else{
        $password = $_POST["pwd"];
    }

    if ($email_err == "" && $password_err == ""){
        $user = find_user($email);

        if ($user == null){
            $email_err = "User doesn't exist. <a href='/user/create.php'>Create account</a>.";
        }
        elseif (trim($user[1]) != trim($password)){
            $password_err = "Incorrect password. Try to remember it!";
        }
        else{
            login($email);
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
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
            echo '<form class="login form" method="post" action="/user/login.php">'.
                    '<label for="email">Email:</label>'.
                    '<input type="email" name="email" id="email" placeholder="Do you like our cats?">'.

                    '<label for="pwd">Password:</label>'.
                    '<input type="password" name="pwd" id="pwd" placeholder="Do you remember your password?">'.
                    '<input type="submit" value="Let me in!">'.
                '</form>'.
                '<div class="register_proposal">Wanna be a member of us? <a href="create.php">Register</a> </div>';
        }
        ?>
    </main>

    <footer>

    </footer>
    </body>
</html>