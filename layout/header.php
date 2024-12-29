<?php
require_once "config.inc.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

?>
<header>
    <h1>TAP</h1>
    <div class="nav-links">
        <?php if ($user && $user instanceof User) { ?>
            <a href="<?php echo ROOT ?>/logout.php">Logout</a>
            <div class="user-section">
                <img src="<?php echo ROOT ?>/assets/images/profile_images/user_profile.jpg" alt="User Photo">
                <a href="<?php echo ROOT ?>/profile.php">
                    <?php echo $user->getName(); ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo ROOT ?>/login.php">Login</a>
                <a href="<?php echo ROOT ?>/register.php">Register</a>
            <?php } ?>
        </div>
    </div>
</header>