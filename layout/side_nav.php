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
            <?php if ($user->getRole() != "Team Member") { ?>
                <a href="<?php echo ROOT ?>/projects.php"><img src="<?php echo $icons_path ?>/view-list.png"
                        alt="view list image"> View Projects</a>
            <?php } ?>

            <?php if ($user->getRole() == "Manager") { ?>
                <a href="<?php echo ROOT ?>/new_project.php"><img src="<?php echo $icons_path ?>/new-project.png"
                        alt="new project image"> New Project</a>
                <a href="<?php echo ROOT ?>/assign_leader.php"><img src="<?php echo $icons_path ?>/assign_leader.png"
                        alt="assign leader image"> Assign Team
                    Leader</a>
            <?php } ?>
            <a href="<?php echo ROOT ?>/tasks.php"><img src="<?php echo $icons_path ?>/view-list.png" alt="view list image">
                Tasks</a>
            <?php if ($user->getRole() == "Project Leader") { ?>
                <a href="<?php echo ROOT ?>/new_task.php"><img src="<?php echo $icons_path ?>/new_task.png"
                        alt="new task image"> New Task</a>
                <a href="<?php echo ROOT ?>/task_details.php"><img src="<?php echo $icons_path ?>/search_task.png"
                        alt="search task image"> View Task Details</a>
                <a href="<?php echo ROOT ?>/assign_member.php"><img src="<?php echo $icons_path ?>/assign_member.png"
                        alt="assign member image"> Assign Team Member To Task</a>
            <?php } ?>

            <?php if ($user->getRole() != "Manager") { ?>
                <a href="<?php echo ROOT ?>/update_task.php"><img src="<?php echo $icons_path ?>/edit.png" alt="edit image">
                    Update Task</a>
            <?php } ?>

            <?php if ($user->getRole() == "Team Member") { ?>
                <a href="<?php echo ROOT ?>/assignments.php"><img src="<?php echo $icons_path ?>/assignments.png"
                        alt="assignments image"> Assignments</a>
            <?php } ?>
        </div>
        <div>
            <a href="<?php echo ROOT ?>/profile.php"><img src="<?php echo $icons_path ?>/profile.png" alt="profile image">
                Profile</a>
            <a href="<?php echo ROOT ?>/logout.php"><img src="<?php echo $icons_path ?>/logout.png" alt="logout image">Log
                out</a>
        </div>
    <?php } ?>
</nav>