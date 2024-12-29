<?php
session_start();
require_once("config.inc.php");
require_once("db.inc.php");
require "./utils/utils.php";
require "./models/User.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = getPostField("username", $errors);
    $password = getPostField("password", $errors);

    if ($username != null)
        $isAvailable = User::isUsernameAvailable($db, $username);

    if (!isset($errors["username"]) && $isAvailable) {
        $errors["username"] = "There is no such username!";
    }

    if (count($errors) == 0) {
        $db_user = $db->fetchOne("SELECT * FROM user WHERE username = ? AND password = ?", [$username, $password]);

        if ($db_user) {
            $user = User::fromArray($db_user);
            $_SESSION["user"] = serialize($user);
            header("Location: index.php");
        } else {
            $errors["username"] = "Invalid username or password!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/register.css">
</head>

<body>
    <?php require_once "./layout/header.php" ?>

    <div class="container">
        <?php require_once "./layout/side_nav.php" ?>
        <main>
            <div class="form-container">
                <h2>Login</h2>
                <form action="<?php echo ROOT ?>/login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                        <?php if (isset($errors['username'])) {
                            echo '<p class="error">' . $errors['username'] . '</p>';
                        } ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <?php if (isset($errors['password'])) {
                            echo '<p class="error">' . $errors['password'] . '</p>';
                        } ?>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <br>
                <a href="<?php echo ROOT ?>/register.php">Does not have an account?</a>
            </div>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>