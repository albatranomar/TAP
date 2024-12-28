<?php
require_once "config.inc.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
}

?>
<header>
    <h1>TAP</h1>
    <div class="nav-links">
        <?php if ($user && $user instanceof User) { ?>
            <a href="/logout">Logout</a>
            <div class="user-section">
                <img src="<?php echo ROOT ?>/assets/images/profile_images/user_profile.jpg" alt="User Photo">
                <a href="<?php echo ROOT ?>/profile.php">User Name</a>
            <?php } else { ?>
                <a href="<?php echo ROOT ?>/login.php">Login</a>
                <a href="<?php echo ROOT ?>/signup.php">Sign Up</a>
            <?php } ?>
        </div>
    </div>
</header>