<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Project.php";
require "./models/Task.php";
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
        header("Location: tasks.php");
    }
} else {
    header("Location: tasks.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $progress = (float) getPostField("progress", $errors);
    if (count($errors) == 0) {
        if ($progress == 0) {
            $task->setStatus("Pending");
        } else if ($progress > 0 && $progress < 100) {
            $task->setStatus("In Progress");
        } else {
            $task->setStatus("Completed");
        }
        $task->setProgress($progress);
        $task->save($db);

        $successPost = true;
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
                <?php if ($user->getRole() == "Team Member") { ?>
                    <section class="form-container">
                        <h1>Update Task</h1>
                        <form action="<?php $_SERVER["REQUEST_URI"] ?>" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="id">Task ID</label>
                                <input disabled type="text" id="id" value="<?php echo $task->getId() ?>">
                            </div>
                            <div>
                                <label for="name">Task Name</label>
                                <input disabled type="text" id="name" value="<?php echo $task->getName() ?>">
                            </div>

                            <div>
                                <label for="project">Project</label>
                                <input disabled type="text" id="project" value="<?php
                                $project = Project::findById($db, $task->getProjectId());
                                if ($project) {
                                    echo $project->getTitle();
                                } else {
                                    echo "Unknown";
                                }
                                ?>">
                            </div>

                            <div>
                                <label for="status">Status *</label>
                                <select id="status" name="status" required>
                                    <option <?php echo ($task->getStatus() == null) ? "selected" : "" ?> disabled>Select Status
                                    </option>
                                    <?php foreach ($db->getEnumValues("task", "status") as $status) { ?>
                                        <option <?php echo ($task->getStatus() == $status) ? "selected" : "" ?>
                                            value="<?php echo $status ?>">
                                            <?php echo $status ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div>
                                <label for="progress">Progress</label>
                                <output for="progress"><?php echo $task->getProgress() ?></output>
                                <input type="range" name="progress" id="progress" min="0" max="100" step="0.1"
                                    value="<?php echo $task->getProgress() ?>"
                                    oninput="this.previousElementSibling.value = this.value">
                                <?php if (isset($errors["progress"])) {
                                    echo '<p class="error">' . $errors['progress'] . '</p>';
                                } ?>
                            </div>

                            <div class="full-width">
                                <button type="submit">Update Task</button>
                            </div>
                            <?php if ($successPost) { ?>
                                <p class="success">Task successfully updated</p>
                            <?php } else if (isset($errors["db"])) {
                                echo '<p class="error">' . $errors['db'] . '</p>';
                            } ?>
                        </form>
                    </section>
                <?php } else { ?>
                    <h1>Access Denied!</h1>
                    <p>only can be accessed by a Team Member!</p>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>