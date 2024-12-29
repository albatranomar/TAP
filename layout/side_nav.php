<?php
require_once "config.inc.php";

$icons_path = ROOT . "/assets/images/icons";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

?>
<nav class="side-nav">
    <?php if ($user && $user instanceof User) { ?>
        <div>
            <a href="#"><img src="<?php echo $icons_path ?>/view-list.png" alt="view list image"> View Projects</a>
            <?php if ($user->getRole() == "Manager") { ?>
                <a href="#"><img src="<?php echo $icons_path ?>/new-project.png" alt="profile image"> New Project</a>
                <a href="#"><img src="<?php echo $icons_path ?>/assign_leader.png" alt="profile image"> Assign Team Leader</a>
            <?php } ?>
            <a href="#"><img src="<?php echo $icons_path ?>/view-list.png" alt="profile image"> Tasks</a>
            <?php if ($user->getRole() == "Project Leader") { ?>
                <a href="#"><img src="<?php echo $icons_path ?>/new_task.png" alt="profile image"> New Task</a>
                <a href="#"><img src="<?php echo $icons_path ?>/search_task.png" alt="profile image"> View Task Details</a>
                <a href="#"><img src="<?php echo $icons_path ?>/assign_member.png" alt="profile image"> Assign Team Member To
                    Task</a>
            <?php } ?>

            <?php if ($user->getRole() != "Manager") { ?>
                <a href="#"><img src="<?php echo $icons_path ?>/edit.png" alt="profile image"> Update Task</a>
            <?php } ?>

            <?php if ($user->getRole() == "Team Member") { ?>
                <a href="#"><img src="<?php echo $icons_path ?>/assignments.png" alt="profile image"> Assignments</a>
            <?php } ?>
        </div>
        <div>
            <a href="#"><img src="<?php echo $icons_path ?>/profile.png" alt="profile image"> Profile</a>
            <a href="#"><img src="<?php echo $icons_path ?>/logout.png" alt="logout image">Log out</a>
        </div>
    <?php } ?>
</nav>