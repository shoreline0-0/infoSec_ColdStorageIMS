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

    $sql = "SELECT * FROM storage";
    $result = mysqli_query($conn, $sql);
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
            <li>
                <a href = "home.php">
                    Home
                </a> 
            </li>
        </ul>
        <link rel = "stylesheet" href = "style.css">
        <title> 
            Storage
        </title>
    </head>
    <body>
    <div class = "storage">
            <table class = "tableStyle">
                <thead>
                    <tr>
                        <th> Storage ID </th>
                        <th> Name </th>    
                        <th> Capacity </th>
                        <th> Temperature </th>
                        <th>
                            <form method='post' action='formCreateStorage.php'>
                                <button type='submit'>
                                    Add Storage
                                </button> 
                            </form>
                        </th>
                    </tr>                    
                </thead>
                <tbody>
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                    echo "<td>" . $row["StorageID"] . "</td>";
                                    echo "<td>" . $row["StorageName"] . "</td>";
                                    echo "<td>" . $row["StorageCapacity"] . "</td>";
                                    echo "<td>" . $row["StorageTemperature"] . "</td>";
                                    echo "<td> 
                                            <form method='post' action='formUpdateStorage.php'>
                                                <input type = 'hidden' name = 'StorageID' value = '". $row['StorageID']. "'/>
                                                <input type = 'hidden' name = 'StorageName' value = '". $row['StorageName']. "'/>      
                                                <input type = 'hidden' name = 'StorageCapacity' value = '". $row['StorageCapacity']. "'/>
                                                <input type = 'hidden' name = 'StorageTemperature' value = '". $row['StorageTemperature']. "'/>
                                                <button type='submit'>
                                                    Update
                                                </button>
                                            </form>
                                            <br>
                                            <form method='post' action='deleteStorage.php'>
                                                <input type = 'hidden' name = 'StorageID' value = '". $row['StorageID']. "'/>
                                                <input type = 'hidden' name = 'StorageName' value = '". $row['StorageName']. "'/>      
                                                <input type = 'hidden' name = 'StorageCapacity' value = '". $row['StorageCapacity']. "'/>
                                                <input type = 'hidden' name = 'StorageTemperature' value = '". $row['StorageTemperature']. "'/>
                                                <button type='submit'>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>";
                                echo "<tr>";
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
