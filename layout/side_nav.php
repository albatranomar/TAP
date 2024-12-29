<?php
require_once "config.inc.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

?>
<nav class="side-nav">
    <?php if ($user && $user instanceof User) { ?>
        <a href="#">Add Task</a>
        <a href="#">Allocate Team Member</a>
    <?php } ?>
</nav>