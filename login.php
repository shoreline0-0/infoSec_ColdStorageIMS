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
?>

<!DOCTYPE html>

<html>
    <head>
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
                        <?php echo $_SESSION['csrf_token']>> ''; ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class = "box1">
                <form method = "post" action = "verifyLogin.php">
                    <input type = "hidden" name = "csrf_token" value = "<?php echo $_SESSION['csrf_token']; ?>">
                    <br><br>
                    <label for = "email">
                        Email:
                    </label>
                    <br>
                    <input type = "text" id = "email" name = "email" value = "<?php echo htmlspecialchars($email); ?>"/>
                    <br>
                    <?php if (isset($errors["email"])): ?>
                        <span class = "error">
                            <?php echo $errors["email"]; ?>
                        </span>
                    <?php endif; ?>
                    <br> <br>
                    <label for = "password">
                        Password:
                    </label>
                    <br>
                    <input type = "password" id = "password" name = "password" />
                    <br>
                    <?php if (isset($errors["password"])): ?>
                        <span class = "error">
                            <?php echo $errors["password"]; ?>
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
