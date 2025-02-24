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
?>

<!DOCTYPE html>

<html>
    <meta http-equiv = "refresh" content = "300; url = index.php">
    <head>
        <ul>
            <li>
                <a href = "index.php">
                    Log out 
                </a> 
            </li>
        </ul>
        <link rel = "stylesheet" href = "style.css">
        <title> 
            Home
        </title>
    </head>
    <body>
        <div class = "home">
            <div class = "container">
                <div class = "box2">
                    <img src = "assets/icon_alerts.png" class = "icons">
                    <button type = "button">
                        <a href = "viewAlerts.php">
                            Alerts
                        </a>
                    </button> 
                </div>
                <div class = "box2">
                    <img src = "assets/icon_batch.png" class = "icons">
                    <button type = "button">
                        <a href = "viewBatch.php">
                            Batch
                        </a>
                    </button> 
                </div> 
                <div class = "box2">
                    <img src = "assets/icon_inventory.png" class = "icons">
                    <button type = "button">
                        <a href = "viewInventory.php">
                            Inventory
                        </a>
                    </button> 
                </div> 
                <div class = "box2">
                    <img src = "assets/icon_product.png" class = "icons">
                    <button type = "button">
                        <a href = "viewProduct.php">
                            Product
                        </a>
                    </button> 
                </div> 
                <div class = "box2">
                    <img src = "assets/icon_storage.png" class = "icons">
                    <button type = "button">
                        <a href = "viewStorage.php">
                            Storage
                        </a>
                    </button> 
                </div> 
                <div class = "box2">
                    <img src = "assets/icon_transactions.png" class = "icons">
                    <button type = "button">
                        <a href = "viewTransactions.php">
                            Transactions
                        </a>
                    </button> 
                </div> 
                <div class = "box2"> <!-- admin only -->
                    <img src = "assets/icon_users.png" class = "icons">
                    <button type = "button">
                        <a href = "viewUsers.php">
                            Users
                        </a>
                    </button> 
                </div> 
            </div>
        </div> 
    </body> 
</html>
