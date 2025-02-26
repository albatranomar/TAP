<?php
require_once "config.inc.php";
require_once "./models/User.php";
require_once "./models/Task.php";

$icons_path = ROOT . "/assets/images/icons";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}


function setup(string $name, bool $hasAssignments = false)
{
    $page = basename($_SERVER["PHP_SELF"]);
    $out = 'href="' . ROOT . '/' . $name . '"';

    $classes = [];

    if ($page == $name) {
        $classes[] = 'active';
    }

    if ($hasAssignments) {
        $classes[] = 'highlight';
    }

    if (!empty($classes)) {
        $out .= ' class="' . implode(' ', $classes) . '"';
    }

    echo $out;
}

?>
<nav class="side-nav">
    <?php if ($user && $user instanceof User) { ?>
        <div>
            <?php if ($user->getRole() != "Team Member") { ?>
                <a <?php setup("projects.php") ?>>
                    <img src="<?php echo $icons_path ?>/view-list.png" alt="view list image"> View Projects
                </a>
            <?php } ?>

            <?php if ($user->getRole() == "Manager") { ?>
                <a <?php setup("new_project.php") ?>>
                    <img src="<?php echo $icons_path ?>/new-project.png" alt="new project image"> New Project
                </a>
                <a <?php setup("assign_leader.php") ?>>
                    <img src="<?php echo $icons_path ?>/assign_leader.png" alt="assign leader image"> Assign Team Leader
                </a>
            <?php } ?>

            <a <?php setup("tasks.php") ?>>
                <img src="<?php echo $icons_path ?>/view-list.png" alt="view list image"> Tasks
            </a>
            <a <?php setup("task_details.php") ?>>
                <img src="<?php echo $icons_path ?>/search_task.png" alt="search task image"> View Task Details
            </a>
            <?php if ($user->getRole() == "Project Leader") { ?>
                <a <?php setup("new_task.php") ?>>
                    <img src="<?php echo $icons_path ?>/new_task.png" alt="new task image"> New Task
                </a>
                <a <?php setup("assign_member.php") ?>>
                    <img src="<?php echo $icons_path ?>/assign_member.png" alt="assign member image"> Assign Team Member To Task
                </a>
            <?php } ?>

            <?php if ($user->getRole() == "Team Member") {
                $not_accepted_tasks = $db->fetchAll("SELECT t.* FROM task t JOIN user_task ut ON t.id = ut.task_id WHERE ut.user_id = ? AND ut.accepted = 0", [$user->getId()]);
                ?>
                <a <?php setup("update_task.php") ?>><img src="<?php echo $icons_path ?>/edit.png" alt="edit image">
                    Update Task</a>
                <a <?php setup("assignments.php", count($not_accepted_tasks) > 0) ?>>
                    <img src="<?php echo $icons_path ?>/assignments.png" alt="assignments image"> Assignments
                </a>

            <?php } ?>
        </div>
        <div>
            <a <?php setup("profile.php") ?>><img src="<?php echo $icons_path ?>/profile.png" alt="profile image">
                Profile</a>
            <a href="<?php echo ROOT ?>/logout.php"><img src="<?php echo $icons_path ?>/logout.png" alt="logout image">Log
                out</a>
        </div>
    <?php } ?>
</nav>