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

    session_start();

    if (!isset($_SESSION['UserID'])) {
        header('Location: logout.php');
        exit();
    }

    $timeout_duration = 300;

    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];
        if ($elapsed_time > $timeout_duration) {
            session_unset();
            session_destroy();
            header('Location: logout.php');
            exit();
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();

    include 'dbconn.php';

    $sql = "SELECT * FROM storage";
    $result = mysqli_query($conn,$sql);

    if (
        isset($_POST['StorageID']) &&
        isset($_POST['StorageName']) &&
        isset($_POST['StorageCapacity']) &&
        isset($_POST['StorageTemperature'])
    ) {
        
        $ProductID = $_POST['StorageID'];
        $ProductName = $_POST['StorageName'];
        $CurrentStock = $_POST['StorageCapacity'];
        $CurrentStock = $_POST['StorageTemperature'];

        $sql = "DELETE FROM storage WHERE StorageID = $StorageID";

        if (mysqli_query($conn,$sql)) {
            header("Location: viewStorage.php?storaget=deleted");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

    } else {
        echo "Missing parameters.";
    }

    mysqli_close($conn);

?>