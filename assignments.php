<?php
session_start();
require "./db.inc.php";
require "./models/User.php";
require "./models/Task.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
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

            <?php if ($user instanceof User) { ?>
                <section>
                    <h1>Assignments</h1>
                    <table>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Start Date</th>
                            <th>Project Title</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $not_accepted_tasks = $db->fetchAll("SELECT t.* FROM task t JOIN user_task ut ON t.id = ut.task_id WHERE ut.user_id = ? AND ut.accepted = 0", [$user->getId()]);
                        foreach ($not_accepted_tasks as $db_task) {
                            $task = Task::fromArray($db_task);
                            if (!($task instanceof Task))
                                continue;
                            ?>
                            <tr>
                                <td><?php echo $task->getId() ?></td>
                                <td><?php echo $task->getName() ?></td>
                                <td><?php echo $task->getStartDate() ?></td>
                                <?php
                                $taskProject = $db->fetchOne("SELECT id, title FROM project WHERE id = (SELECT project_id FROM task WHERE id = ?)", [$task->getId()]);
                                if ($taskProject != null) {
                                    echo "<td>" . $taskProject["title"] . "</td>";
                                } else {
                                    echo "<td>Unkown</td>";
                                }
                                ?>
                                <td>
                                    <a href="./confirm_assignment.php?tid=<?php echo $task->getId() ?>">Confirm</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </section>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>