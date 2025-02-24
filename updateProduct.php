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
    $ProductName = $CurrentStock = "";

    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn,$sql);

    if (
        isset($_POST['ProductID']) &&
        isset($_POST['ProductName']) &&
        isset($_POST['CurrentStock']) 
    ) {
        $ProductID = $_POST['ProductID'];
        $ProductName = htmlspecialchars($_POST['ProductName'], ENT_QUOTES, 'UTF-8');
        $CurrentStock = filter_input(INPUT_POST, 'CurrentStock', FILTER_VALIDATE_INT);

        if (empty($ProductName)) {
            $errors['ProductName'] = "Product name required.";
        } elseif (strlen($ProductName) > 50) {
            $errors['ProductName'] = "Product name too long.";
        }
    
        if ($CurrentStock < 0) {
            $errors['CurrentStock'] = "Invalid stock.";
        }
    
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['ProductName'] = $ProductName;
            $_SESSION['CurrentStock'] = $CurrentStock;
            
            header("Location: formEditProduct.php");
            exit();
        } else {
            $sql = 
            "UPDATE product 
            SET 
                ProductName = ?, 
                CurrentStock = ?
            WHERE ProductID = ?";
            
            $stmt = mysqli_prepare($conn, $sql);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sii", $ProductName, $CurrentStock, $ProductID);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: viewProducts.php?product=updated");
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