<?php
session_start();
require "./models/User.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <?php require_once "./layout/header.php" ?>

    <div class="container">
        <?php require_once "./layout/side_nav.php" ?>
        <main>
            <?php if ($user && $user instanceof User) { ?>
                <h2>Welcome <?php echo $user->getName() ?></h2>
                <p>This is where the main content will appear.</p>
            <?php } else { ?>
                <h2>Access Denied!</h2>
                <a class="go-to-login" href="./login.php">Go Login</a>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>