<?php
    header("
        Content-Security-Policy: default-src 'self;
        script-src 'self';
        style-src 'self';
        img-src 'self';
        font-src 'self';
        object-src 'self';
        frame-ancestors 'none':
        base-uri 'self';
        form-actioon 'self';
        X-Content-Type-Options: nosniff
    ")

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ])

    session_start();

    include 'dbconn.php';
    
    if (isset($_SESSION["UserID"])) {
        $UserID = $_SESSION["UserID"];
       
        session_unset();
        session_destroy();
    }

    header("Location: index.php");
    exit();
?>