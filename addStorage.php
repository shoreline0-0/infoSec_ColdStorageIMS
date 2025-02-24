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

    $errors = [];
    $StorageName = $StorageCapacity = $StorageTemperature = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $StorageName = htmlspecialchars($_POST['StorageName'], ENT_QUOTES, 'UTF-8');
        $StorageCapacity = filter_input(INPUT_POST, 'StorageCapacity', FILTER_VALIDATE_INT);
        $StorageTemperature = filter_input(INPUT_POST, 'StorageTemperature', FILTER_VALIDATE_INT);

        if (empty($StorageName)) {
            $errors['StorageName'] = "Storage name required.";
        } elseif (strlen($StorageName) > 50) {
            $errors['StorageName'] = "Storage name too long.";
        }
    
        if (empty($StorageCapacity)) {
            $errors['StorageCapacity'] = "Capacity required.";
        } elseif ($StorageCapacity < 0) {
            $errors['StorageCapacity'] = "Invalid capacity.";
        }

        if (empty($StorageTemperature)) {
            $errors['StorageTemperature'] = "Temperature required.";
        } elseif ($StorageTemperature > 100) {
            $errors['StorageTemperature'] = "Invalid temperature.";
        }
    
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['StorageName'] = $ProductName;
            $_SESSION['StorageCapacity'] = $StorageCapacity;
            $_SESSION['StorageTemperature'] = $StorageTemperature;
            
            header("Location: formCreateStorage.php");
            exit();
    
        } else {
            $sql = "INSERT INTO product (StorageName, StorageCapacity, StorageTemperature) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sii", $StorageName, $StorageCapacity, $StorageTemperature);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: viewStorage.php?storage=created");
                    exit();
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement.";
            }
        }    
    }
?>