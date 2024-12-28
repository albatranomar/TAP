<?php session_start(); ?>
<?php require_once "config.inc.php"; ?>
<header>
    <h1>TAP</h1>
    <div class="nav-links">
        <a href="/login">Login</a>
        <a href="/signup">Sign Up</a>
        <a href="/logout">Logout</a>
        <div class="user-section">
            <img src="<?php echo ROOT ?>/assets/images/user_profile.jpg" alt="User Photo">
            <a href="#">User Name</a>
        </div>
    </div>
</header>