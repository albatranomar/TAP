<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Project.php";
require "./models/Task.php";
require "./models/UserTask.php";
require "./utils/utils.php";

$user = null;
$errors = [];
$successPost = false;
$task = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if (isset($_GET["tid"])) {
    $task = Task::findById($db, $_GET["tid"]);

    if (!$task) {
        header("Location: assignments.php");
    }
} else {
    header("Location: assignments.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $task instanceof Task && $user instanceof User && $user->getRole() == "Team Member") {
    $accepted = isset($_POST["accept"]);
    $rejected = isset($_POST["reject"]);

    if ($accepted && !$rejected) {
        $db->execute("UPDATE user_task SET accepted = TRUE WHERE user_id = ? AND task_id = ?", [$user->getId(), $task->getId()]);
        $task->setStatus("In Progress");
        $task->save($db);
        header("Location: tasks.php");
    }

    if ($rejected && !$accepted) {
        $db->execute("DELETE FROM user_task WHERE user_id = ? AND task_id = ?", [$user->getId(), $task->getId()]);
        header("Location: tasks.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/new_project.css">
    <link rel="stylesheet" href="./assets/css/confirm_assignment.css">
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

            <?php if ($user instanceof User && $task instanceof Task) { ?>
                <?php
                $user_tasks = UserTask::findByUserId($db, $user->getId());
                $user_task = null;

                foreach ($user_tasks as $user_task_) {
                    if ($user_task_ instanceof UserTask && $user_task_->getTaskId() == $task->getId()) {
                        $user_task = $user_task_;

                    }
                }
                ?>
                <?php if ($user->getRole() == "Team Member" && $user_task) { ?>
                    <section class="form-container">
                        <h1>Confirm Task</h1>
                        <form>
                            <div>
                                <label for="id">Task ID</label>
                                <input type="text" id="id" disabled value="<?php echo $task->getId() ?>">
                            </div>
                            <div>
                                <label for="name">Task Name</label>
                                <input type="text" id="name" disabled value="<?php echo $task->getName() ?>">
                            </div>
                            <div class="full-width">
                                <label for="description">Task Description</label>
                                <textarea id="description" disabled><?php echo $task->getDescription() ?></textarea>
                            </div>
                            <div>
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" disabled value="<?php echo $task->getStartDate() ?>">
                            </div>
                            <div>
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" disabled value="<?php echo $task->getEndDate() ?>">
                            </div>
                            <div>
                                <label for="effort">Effort</label>
                                <input type="number" id="effort" disabled value="<?php echo $task->getEffort() ?>">
                            </div>
                            <div>
                                <label for="priority">Priority</label>
                                <input type="text" id="priority" disabled value="<?php echo $task->getPriority() ?>">
                            </div>
                            <div>
                                <label for="status">Status</label>
                                <input type="text" id="status" disabled value="<?php echo $task->getStatus() ?>">
                            </div>
                            <div>
                                <label for="role">Role</label>
                                <input type="text" id="role" disabled value="<?php echo $user_task->getRole() ?>">
                            </div>
                        </form>
                        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                            <button name="accept" type="submit" class="accept-button">Accept &check;</button>
                        </form>
                        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                            <button name="reject" type="submit" class="reject-button">Reject ☓</button>
                        </form>
                    </section>
                <?php } else { ?>
                    <h1>Access Denied!</h1>
                    <p>only can be accessed by a Team Member OR the task is not yours!</p>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>