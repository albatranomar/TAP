<?php
session_start();
require "./db.inc.php";
require "./utils/utils.php";
require "./models/User.php";
require "./models/Task.php";
require "./models/UserTask.php";

$user = null;
$task = null;
$errors = [];
$error = null;
$successPost = false;

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["member"]) && isset($_GET["tid"]) && $user && $user instanceof User && $user->getRole() == "Project Leader") {
        $task = Task::findById($db, $_GET["tid"]);
        if (!$task) {
            header("Location: tasks.php");
            return;
        }

        $member = User::findById($db, $_POST["member"]);

        if (!$member) {
            $errors["member"] = "Invalid Member Provided!";
        } else {
            $role = getPostField("role", $errors);
            $contribution = getPostField("contribution", $errors);
            $start_date = getPostField("start_date", $errors);
            if ($role && $contribution && $start_date) {
                $submittedDate = new DateTime($start_date);
                $minDate = new DateTime($task->getStartDate());
                $maxDate = new DateTime($task->getEndDate());

                if ($submittedDate < $minDate || $submittedDate > $maxDate) {
                    $errors["start_date"] = "Start date must be between " . $task->getStartDate() . " and " . $task->getEndDate();
                }


                $users_tasks = UserTask::findByTaskId($db, $task->getId());
                $total_contribution = 0;

                if (count($users_tasks) > 0) {
                    foreach ($users_tasks as $user_task) {
                        if ($user_task instanceof UserTask) {
                            $total_contribution += $user_task->getContribution();
                        }
                    }
                }

                if ($total_contribution >= 100) {
                    $errors["contribution"] = "The contribution is 100% right now!";
                }

                if ($total_contribution < 100 && $contribution > (100 - $total_contribution)) {
                    $errors["contribution"] = "Can only give maximum " . (100 - $total_contribution) . "%";
                }

                if (count($errors) <= 0) {
                    $user_task = new UserTask($_POST["member"], $task->getId(), $role, $contribution, false, $start_date);
                    $success = $user_task->save($db);
                    if ($success) {
                        $successPost = [];
                        $successPost["role"] = $role;
                    } else {
                        $error = "Unable to add to the database!";
                    }
                }
            }
        }
    } else {
        $error = "Invalid Parameters Provided!";
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
    <link rel="stylesheet" href="./assets/css/allocate_leader.css">
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
                        <h1>Allocate Team Member</h1>
                        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                            <div>
                                <label for="id">Task ID</label>
                                <input disabled type="text" id="id" value="<?php echo $task->getId() ?>">
                            </div>
                            <div>
                                <label for="name">Task Name</label>
                                <input disabled type="text" id="name" value="<?php echo $task->getName() ?>">
                            </div>
                            <div>
                                <label for="start_date">Start Date *</label>
                                <input type="date" id="start_date" name="start_date" max="<?php echo $task->getEndDate() ?>"
                                    min="<?php echo $task->getStartDate() ?>" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div>
                                <?php
                                $members = User::findAll($db);
                                ?>
                                <label for="member">Team Member *</label>
                                <select id="member" name="member" required>
                                    <option selected disabled>Select Team Member</option>
                                    <?php foreach ($members as $member) { ?>
                                        <?php if ($member instanceof User && $member->getRole() == "Team Member") { ?>
                                            <option value="<?php echo $member->getId() ?>">
                                                <?php echo $member->getName() . ' - ' . $member->getId() ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if (isset($errors['member'])) {
                                    echo '<p class="error">' . $errors['member'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="role">Role *</label>
                                <select id="role" name="role" required>
                                    <option selected disabled>Select Role</option>
                                    <option>Developer</option>
                                    <option>Designer</option>
                                    <option>Tester</option>
                                    <option>Analyst</option>
                                    <option>Support</option>
                                </select>
                                <?php if (isset($errors['role'])) {
                                    echo '<p class="error">' . $errors['role'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="contribution">Contribution *</label>
                                <input type="number" id="contribution" name="contribution" min="1" max="100" step="0.01"
                                    required>
                                <?php if (isset($errors['contribution'])) {
                                    echo '<p class="error">' . $errors['contribution'] . '</p>';
                                } ?>
                            </div>
                            <div class="full-width">
                                <button type="submit">Finish Allocation</button>
                            </div>
                        </form>
                        <?php if ($successPost) { ?>
                            <p class="success">Team member successfully assigned to Task <?php echo $task->getId() ?> as
                                <?php echo $successPost["role"] ?>.
                            </p>
                        <?php } else { ?>
                            <?php if (!is_null($error)) { ?>
                                <p class="error"><?php echo $error ?></p>
                            <?php } ?>
                        <?php } ?>
                    </section>
                <?php } else { ?>
                    <h1>Access Denied!</h1>
                    <p>only can be accessed by a project leaders!</p>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>