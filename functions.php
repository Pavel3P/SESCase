<?php

$USERS_FILENAME = "users.csv";

function create_error_block($error_message){
    return "<div class='error'>".$error_message."</div>";
}

function create_header(){
    $username = "Anonymous";
    $action_block = "<a href='/user/login.php'>Login</a>/<a href='/user/create.php'>Register</a>";
    if (isset($_SESSION["user"])){
        $username = $_SESSION["user"];
        $action_block = "<a href='/user/logout.php'>Logout</a>";
    }

    echo "<header class='header'>".
                "<div class='logo'></div>".
                "<div class='header_greetings'>Hello, ".$username."!</div>".
                "<div class='btcRate_button'><a href='/btcRate.php'>BTC Rate</a></div>".
                "<div class='actions'>".$action_block."</div>".
            "</header>";
}

function find_user($email){
    $users_file = fopen($GLOBALS["USERS_FILENAME"], "c+");
    $user = null;

    while (($line = fgets($users_file)) !== false){
        $data = explode(";", $line);
        if ($data[0] == $email){
            $user = $data;
            break;
        }
    }

    return $user;
}

function login($email){
    $_SESSION["user"] = substr($email, 0, strpos($email, "@"));
    header("Location: /btcRate.php");
}

function add_user($email, $password){
    $users_file = fopen($GLOBALS["USERS_FILENAME"], "a");
    fwrite($users_file, $email.";".$password."\n");
}

function is_bad_password($password){
    $bad_symbols = ";.,\/";
    foreach (str_split($bad_symbols) as $char){
        if (strpos($password, $char) != false){
            return true;
        }
    }

    return false;
}