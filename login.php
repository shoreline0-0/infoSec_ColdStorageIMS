<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; font-src 'self'; object-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
    header("X-Content-Type-Options: nosniff");

    session_start();
    
    include 'dbconn.php';

    $errors = $_SESSION['errors'] ?? "";
    $Email = $_SESSION['Email'] ?? "";

    unset(
        $_SESSION['errors'],
        $_SESSION['Email']
    );
?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title> Log-in </title>
    </head>
    <body>
        <div class = "login">
            <h1>
                Log-in 
            </h1>
            <div>
                <?php if (isset($errors["general"])): ?>
                    <p class = "error">
                        <?php echo $errors['general']; ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class = "box1">
                <form method = "post" action = "verifyLogin.php">
                    <label for = "Email">
                        Email:
                    </label>
                    <br>
                    <input type = "text" id = "Email" name = "Email" value = "<?php echo htmlspecialchars($Email); ?>"/>
                    <br>
                    <?php if (isset($errors["Email"])): ?>
                        <span class = "error">
                            <?php echo $errors["Email"]; ?>
                        </span>
                    <?php endif; ?>
                    <br> <br>
                    <label for = "Password">
                        Password:
                    </label>
                    <br>
                    <input type = "Password" id = "Password" name = "Password" />
                    <br>
                    <?php if (isset($errors["Password"])): ?>
                        <span class = "error">
                            <?php echo $errors["Password"]; ?>
                        </span>
                    <?php endif; ?>
                    <br> <br>
                    <button class = "verifyLogin" type = "submit">
                        Login 
                    </button>
                    <br> <br>
                    <button type = "button">
                        <a href="index.php">
                            Back 
                        </a>
                    </button>
                </form>
            </div>
        </div> 
    </body> 
</html>
