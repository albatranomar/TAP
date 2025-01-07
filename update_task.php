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
    $name = getPostField("name", $errors);
    $description = getPostField("description", $errors);
    $project_id = getPostField("project", $errors);
    $start_date = getPostField("start_date", $errors);
    $end_date = getPostField("end_date", $errors);
    $effort = getPostField("effort", $errors);
    $priority = getPostField("priority", $errors);

    if (count($errors) == 0) {
        $project = Project::findById($db, $project_id);

        if ($project) {
            if (strtotime($start_date) <= strtotime(date('Y-m-d')) || strtotime($start_date) < strtotime($project->getStartDate())) {
                $errors["start_date"] = "Start Date must be greater than today and greater or equal to the start date of the project!";
            }

            if (strtotime($end_date) <= strtotime($start_date) || strtotime($end_date) > strtotime($project->getEndDate())) {
                $errors["end_date"] = "End Date must be later than Start Date and less than or equal to the end date of the project!";
            }
        } else {
            $errors["project"] = "Invalid Project provided!";
        }

        if (!is_numeric($effort) || ((float) $effort) <= 0) {
            $errors["effort"] = "Total Budget must be a positive numeric value!";
        }

        if (count($errors) == 0) {
            try {
                $createdTask = new Task(null, $name, $description, $project_id, $start_date, $end_date, $effort, "Pending", $priority, 0);
                $createdTask->save($db);

                $successPost = true;
            } catch (Exception $e) {
                $errors["db"] = $e->getMessage();
            }
        }
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
                <?php if ($user->getRole() == "Project Leader") { ?>
                    <section class="form-container">
                        <h1>Update Task</h1>
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="name">Task Name *</label>
                                <input type="text" id="name" name="name" required value="<?php echo $task->getName() ?>">
                                <?php if (isset($errors['name'])) {
                                    echo '<p class="error">' . $errors['name'] . '</p>';
                                } ?>
                            </div>
                            <div class="full-width">
                                <label for="description">Task Description *</label>
                                <textarea id="description" name="description"
                                    required><?php echo $task->getDescription() ?></textarea>
                                <?php if (isset($errors['description'])) {
                                    echo '<p class="error">' . $errors['description'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <?php
                                $projects = $db->fetchAll("SELECT * FROM project WHERE team_leader = ?", [$user->getId()]);
                                ?>
                                <label for="project">Project *</label>
                                <select id="project" name="project" required>
                                    <option <?php ($task->getProjectId() == null) ? "selected" : "" ?> disabled>Select Project
                                    </option>
                                    <?php foreach ($projects as $project) { ?>
                                        <option <?php ($task->getProjectId() == $project["id"]) ? "selected" : "" ?>
                                            value="<?php echo $project["id"] ?>">
                                            <?php echo $project["title"] . ' - ' . $project["id"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($errors['project'])) {
                                    echo '<p class="error">' . $errors['project'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="start_date">Start Date *</label>
                                <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required
                                    value="<?php echo $task->getStartDate() ?>">
                                <?php if (isset($errors['start_date'])) {
                                    echo '<p class="error">' . $errors['start_date'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="end_date">End Date *</label>
                                <input type="date" id="end_date" name="end_date" required
                                    value="<?php echo $task->getEndDate() ?>">
                                <?php if (isset($errors['end_date'])) {
                                    echo '<p class="error">' . $errors['end_date'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="effort">Effort *</label>
                                <input type="number" id="effort" name="effort" min="0" required
                                    value="<?php echo $task->getEffort() ?>">
                                <?php if (isset($errors['effort'])) {
                                    echo '<p class="error">' . $errors['effort'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="priority">Priority *</label>
                                <select id="priority" name="priority" required>
                                    <option <?php echo ($task->getPriority() == null) ? "selected" : "" ?> disabled>Select
                                        Priority</option>
                                    <?php foreach ($db->getEnumValues("task", "priority") as $priority) { ?>
                                        <option <?php echo ($task->getPriority() == $priority) ? "selected" : "" ?>
                                            value="<?php echo $priority ?>">
                                            <?php echo $priority ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($errors['priority'])) {
                                    echo '<p class="error">' . $errors['priority'] . '</p>';
                                } ?>
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
                                <?php if (isset($errors['status'])) {
                                    echo '<p class="error">' . $errors['status'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="progress">Progress</label>
                                <output for="progress"><?php echo $task->getProgress() ?></output>
                                <input type="range" name="progress" id="progress" min="0" max="100" step="0.1"
                                    value="<?php echo $task->getProgress() ?>"
                                    oninput="this.previousElementSibling.value = this.value">
                            </div>

                            <div class="full-width">
                                <button type="submit">Update Task</button>
                            </div>
                            <?php if ($successPost && $createdTask != null && $createdTask instanceof Task) { ?>
                                <p class="success">Task <?php echo $createdTask->getName() ?> successfully updated</p>
                            <?php } else if (isset($errors["db"])) {
                                echo '<p class="error">' . $errors['db'] . '</p>';
                            } ?>
                        </form>
                    </section>
                <?php } else { ?>
                    <h1>Access Denied!</h1>
                    <p>only can be accessed by a Project Leader!</p>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>