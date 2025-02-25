<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; font-src 'self'; object-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
    header("X-Content-Type-Options: nosniff");
    include 'dbconn.php'
?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title> Index </title>
    </head>
    <body>
        <div class = "index">
            <div class = "box2">
                <button type = "button">
                    <a href = "login.php">
                        Log-in
                    </a>
                </button> 
            </div> 
        </div> 
    </body> 
</html>
