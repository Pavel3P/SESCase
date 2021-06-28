<?php
include "functions.php";
if (isset($_SESSION) == false){
    session_start([
        "cookie_lifetime" => 3600,
    ]);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BTC Rate</title>
        <link rel="stylesheet" href="/source/style.css">
    </head>

    <body>
    <?php
    create_header();
    ?>

    <main>
        <div class="btc">
            <?php
            if (isset($_SESSION["user"])) {
                $btc_url = 'https://bitpay.com/api/rates';
                $json = json_decode(file_get_contents($btc_url));
                $btc = 0;

                foreach ($json as $obj) {
                    if ($obj->code == "UAH") $btc = $obj->rate;
                }

                echo "1 BTC=" . $btc . "UAH<br/>";
            }
            else{
                echo "Looks like you're not authorized. <a href='/user/login.php'>Login</a> or <a href='/user/create.php'>Create account</a>";
            }
            ?>
        </div>
    </main>
    <footer>

    </footer>
    </body>
</html>