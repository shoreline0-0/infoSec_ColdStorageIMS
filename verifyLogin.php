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


    include 'dbconn.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $errors = [];
        $email = "";

        $email = filter_var($POST["email"], FILTER_SANITIZE_EMAIL);
        $loginPW = htmlspecialchars(trim($_POST["password"]), ENT_QUOTES, "UTF-8");
        //$hashedInput = hash("sha256", $loginPW);

        if (empty($email)) {
            $errors["email"] = "Email required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email.";
        }

        if (empty($loginPW)) {
            $errors["password"] = "Password required.";
        }

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["email"] = $email;

            header("Location: login.php")
            exit();
        }

        $sql = "SELECT * FROM users WHERE Email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                $hashedPW = $user['password'];

                $access = 'login';
        
                if ($hashedInput == $hashedPW) {
                    $_SESSION['UserID'] = $user['userID'];
                    $_SESSION['FirstName'] = $user['FirstName'];
                    $_SESSION['Role'] = $user['Role'];

                } else {
                    $errors['password'] = "Incorrect password.";
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        $_SESSION['email'] = $email;
                        
                        header("Location: login.php");               
                        exit();
                    }                  
                }
            } else {
                $errors['email'] = "Account does not exist!";     
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    $_SESSION['email'] = $email;
                    
                    header("Location: login.php");               
                    exit();
                }    
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Database error: " . mysqli_error($conn);
        }
    }
?>
