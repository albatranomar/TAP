<?php
session_start();

require_once "db.inc.php";
require_once "config.inc.php";
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
    <link rel="stylesheet" href="./assets/css/profile.css">
</head>

<body>
    <?php require_once "./layout/header.php" ?>

    <div class="container">
        <?php require_once "./layout/side_nav.php" ?>
        <main>
            <?php if (!$user) { ?>
                <h1>Access Denied!</h1>
                <a class="go-to-login" href="./login.php">Go Login</a>
            <?php } ?>

            <?php if ($user instanceof User) { ?>
                <div class="profile-container">
                    <h1>User Profile</h1>
                    <figure>
                        <img src="<?php echo ROOT ?>/assets/images/profile_images/<?php echo $user->getImage(); ?>"
                            alt="User Photo">
                    </figure>
                    <section>
                        <label>Name:</label>
                        <p><?php echo $user->getName() ?></p>
                    </section>
                    <section>
                        <label>Date of Birth:</label>
                        <p><?php echo $user->getDob() ?></p>
                    </section>
                    <section>
                        <label>Email:</label>
                        <p><?php echo $user->getEmail() ?></p>
                    </section>
                    <section>
                        <label>Phone:</label>
                        <p><?php echo $user->getPhone() ?></p>
                    </section>
                    <section>
                        <label>Role:</label>
                        <p><?php echo $user->getRole() ?></p>
                    </section>
                    <section>
                        <label>Qualification:</label>
                        <p><?php echo $user->getQualification() ?></p>
                    </section>
                </div>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>