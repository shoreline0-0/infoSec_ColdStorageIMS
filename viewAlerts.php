<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; font-src 'self'; object-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
    header("X-Content-Type-Options: nosniff");

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

    $sql = "SELECT * FROM alerts";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>

<html>
    <head>
        <ul>
            <li>
                <a href = "index.php">
                    Log out 
                </a> 
            </li>
            <li>
                <a href = "home.php">
                    Home
                </a> 
            </li>
        </ul>
        <link rel = "stylesheet" href = "style.css">
        <title> 
            Alerts
        </title>
    </head>
    <body>
        <div class = "alerts">
            <table class = "tableStyle">
                <thead>
                    <tr>
                        <th> Alert ID </th>
                        <th> Product ID </th>    
                        <th> Storage ID  </th>
                        <th> Name </th>
                        <th> Time </th>                            
                        <th> Status </th>
                        <th> Notes </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row["AlertID"] . "</td>";
                                echo "<td>" . $row["ProductID"] . "</td>";                                        
                                echo "<td>" . $row["StorageID"] . "</td>";
                                echo "<td>" . $row["AlertName"] . "</td>";
                                echo "<td>" . $row["AlertTime"] . "</td>";
                                echo "<td>" . $row["Status"] . "</td>";
                                echo "<td>" . $row["Notes"] . "</td>";
                            }
                        } else {
                            echo "<tr><td>No records.</td></tr>";
                        }
                        mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div> 
    </body> 
</html>
