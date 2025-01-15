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
$createdTask = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user && $user instanceof User && $user->getRole() == "Project Leader") {
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
            if (strtotime($start_date) < strtotime(date('Y-m-d'))) {
                $errors["start_date"] = "Start Date must be after today!";
            } else if (strtotime($start_date) < strtotime($project->getStartDate())) {
                $errors["start_date"] = "Start Date must be after the start date of the project! [ " . $project->getStartDate() . " ]";
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

            <?php if ($user instanceof User) { ?>
                <?php if ($user->getRole() == "Project Leader") { ?>
                    <section class="form-container">
                        <h1>Create a Task</h1>
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="name">Task Name *</label>
                                <input type="text" id="name" name="name" required>
                                <?php if (isset($errors['name'])) {
                                    echo '<p class="error">' . $errors['name'] . '</p>';
                                } ?>
                            </div>
                            <div class="full-width">
                                <label for="description">Task Description *</label>
                                <textarea id="description" name="description" required></textarea>
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
                                    <option selected disabled>Select Project</option>
                                    <?php foreach ($projects as $project) { ?>
                                        <option value="<?php echo $project["id"] ?>">
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
                                <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>"
                                    required>
                                <?php if (isset($errors['start_date'])) {
                                    echo '<p class="error">' . $errors['start_date'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="end_date">End Date *</label>
                                <input type="date" id="end_date" name="end_date" required>
                                <?php if (isset($errors['end_date'])) {
                                    echo '<p class="error">' . $errors['end_date'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="effort">Effort *</label>
                                <input type="number" id="effort" name="effort" min="0" required>
                                <?php if (isset($errors['effort'])) {
                                    echo '<p class="error">' . $errors['effort'] . '</p>';
                                } ?>
                            </div>

                            <div>
                                <label for="priority">Priority *</label>
                                <select id="priority" name="priority" required>
                                    <option selected disabled>Select Priority</option>
                                    <?php foreach ($db->getEnumValues("task", "priority") as $priority) { ?>
                                        <option value="<?php echo $priority ?>">
                                            <?php echo $priority ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($errors['priority'])) {
                                    echo '<p class="error">' . $errors['priority'] . '</p>';
                                } ?>
                            </div>

                            <div class="full-width">
                                <button type="submit">Create Task</button>
                            </div>
                            <?php if ($successPost && $createdTask != null && $createdTask instanceof Task) { ?>
                                <p class="success">Task <?php echo $createdTask->getName() ?> successfully created</p>
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