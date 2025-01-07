<?php
session_start();
require "./db.inc.php";
require "./models/User.php";
require "./models/Project.php";
require "./models/Task.php";

$user = null;
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/task_details.css">
    <link rel="stylesheet" href="./assets/css/tables.css">
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
                <section class="details-container">
                    <div class="area">
                        <h2>Task Details</h2>
                        <div>
                            <span>Task ID:</span> <?php echo $task->getId() ?>
                        </div>
                        <div>
                            <span>Task Name:</span> <?php echo $task->getName() ?>
                        </div>
                        <div>
                            <span>Description:</span> <?php echo $task->getDescription() ?>
                        </div>
                        <div>
                            <span>Project:</span>
                            <?php
                            $project = Project::findById($db, $task->getProjectId());
                            if (!$project) {
                                echo "Unknown";
                            } else {
                                echo $project->getTitle();
                            }
                            ?>
                        </div>
                        <div>
                            <span>Start Date:</span> <?php echo $task->getStartDate() ?>
                        </div>
                        <div>
                            <span>End Date:</span> <?php echo $task->getEndDate() ?>
                        </div>
                        <div>
                            <span>Completion Percentage:</span> <?php echo $task->getProgress() ?>%
                        </div>
                        <div>
                            <span>Status:</span> <?php
                            if ($task->getStatus() == "In Progress") {
                                echo "<span class=\"highlight\">In Progress</span>";
                            } else {
                                echo $task->getStatus();
                            }
                            ?>
                        </div>
                        <div>
                            <span>Priority:</span> <?php echo $task->getPriority() ?>
                        </div>
                    </div>

                    <div class="area">
                        <?php
                        $members = $db->fetchAll("SELECT u.*, ut.start_date, ut.end_date, ut.contribution FROM user u, user_task ut WHERE u.id = ut.user_id AND ut.task_id = ?", [$task->getId()]);
                        ?>
                        <h2>Team Members</h2>
                        <table>
                            <tr>
                                <th>Photo</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Effort Allocated (%)</th>
                            </tr>
                            <?php foreach ($members as $db_member) {
                                $member = User::fromArray($db_member);
                                ?>
                                <tr>
                                    <td><img src="./assets/images/profile_images/<?php echo $member->getImage() ?>"
                                            alt="<?php echo $member->getName() ?>" class="team-member-photo"></td>
                                    <td><?php echo $member->getId() ?></td>
                                    <td><?php echo $member->getName() ?></td>
                                    <td><?php echo $db_member["start_date"] ?></td>
                                    <td><?php
                                    if (!empty($db_member["end_date"])) {
                                        echo $db_member["end_date"];
                                    } else {
                                        echo "<span class=\"highlight\">In Progress</span>";
                                    }
                                    ?></td>
                                    <td><?php echo ((float) $db_member["contribution"]) ?>%</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </section>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>