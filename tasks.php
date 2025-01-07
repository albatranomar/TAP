<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Task.php";
require "./models/Project.php";
require "./layout/tasks/search_form.php";

$icons_path = ROOT . "/assets/images/icons";

$user = null;
$project = null;
$search_values = [];
$sortOn = null;
$sortOrder = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $project_id = isset($_GET["pid"]) ? $_GET["pid"] : null;
    $project = $project_id != null ? Project::findById($db, $project_id) : null;

    if ($user != null && $user->getRole() != "Manager") {
        $search_values["user_id"] = (int) $user->getId();
    }

    if ($project != null) {
        $search_values["project_id"] = $project->getId();
    }

    $id = !empty($_GET["id"]) ? $_GET["id"] : null;
    $name = !empty($_GET["name"]) ? $_GET["name"] : null;
    $priority = !empty($_GET["priority"]) ? $_GET["priority"] : null;
    $status = !empty($_GET["status"]) ? $_GET["status"] : null;
    $start_date = !empty($_GET["start_date"]) ? $_GET["start_date"] : null;
    $end_date = !empty($_GET["end_date"]) ? $_GET["end_date"] : null;
    $sortOn = !empty($_GET["sort_on"]) ? $_GET["sort_on"] : null;
    $sortOrder = !empty($_GET["sort_order"]) ? $_GET["sort_order"] : null;

    if ($id != null)
        $search_values["id"] = $id;

    if ($name != null)
        $search_values["name"] = $name;

    if ($priority != null)
        $search_values["priority"] = $priority;

    if ($status != null)
        $search_values["status"] = $status;

    if ($start_date != null)
        $search_values["start_date"] = $start_date;

    if ($end_date != null)
        $search_values["end_date"] = $end_date;
}

function generateTaskSearchQuery($params, $userType, $sortOn, $sortOrder)
{
    $query = "SELECT t.*, (SELECT COUNT(*) FROM user_task ut WHERE ut.task_id = t.id) AS member_count FROM task t";

    if ($userType === 'Project Leader') {
        $query .= " JOIN project p ON t.project_id = p.id";
    } elseif ($userType === 'Team Member') {
        $query .= " JOIN user_task ut ON t.id = ut.task_id";
    }

    $conditions = [];

    if ($userType == 'Project Leader') {
        $conditions[] = "p.team_leader = :user_id";
    } elseif ($userType == 'Team Member') {
        $conditions[] = "ut.user_id = :user_id AND ut.accepted = 1";
    }

    if (!empty($params['id'])) {
        $conditions[] = "t.id = :id";
    }

    if (!empty($params['name'])) {
        $conditions[] = "t.name LIKE CONCAT('%', :name, '%')";
    }

    if (!empty($params['project_id'])) {
        $conditions[] = "t.project_id = :project_id";
    }

    if (!empty($params['priority'])) {
        $conditions[] = "t.priority = :priority";
    }

    if (!empty($params['status'])) {
        $conditions[] = "t.status = :status";
    }

    if (!empty($params['start_date']) && !empty($params['end_date'])) {
        $conditions[] = "t.start_date <= :end_date AND t.end_date >= :start_date";
    } elseif (!empty($params['start_date'])) {
        $conditions[] = "t.end_date >= :start_date";
    } elseif (!empty($params['end_date'])) {
        $conditions[] = "t.start_date <= :end_date";
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    if ($sortOn != null) {
        $query .= " ORDER BY t.$sortOn $sortOrder";
    } else {
        $query .= " ORDER BY member_count ASC, t.id ASC";
    }

    return $query;
}

function handleSort(string $target)
{
    global $sortOrder;
    $type = $sortOrder != null && $sortOrder == "asc" ? "desc" : "asc";

    $_GET["sort_on"] = $target;
    $_GET["sort_order"] = $type;

    echo http_build_query($_GET);
}

function handleSortArrow(string $target)
{
    global $sortOn, $sortOrder;
    echo $sortOn && $sortOn == $target
        ? ($sortOrder && $sortOrder == "asc" ? "&darr;" : "&uarr;")
        : "";
}

function getStatusClass(Task $task)
{
    if ($task->getStatus() == "Pending") {
        echo "pending";
    } else if ($task->getStatus() == "In Progress") {
        echo "in-progress";
    } else if ($task->getStatus() == "Completed") {
        echo "completed";
    }
}

function getPriorityClass(Task $task)
{
    if ($task->getPriority() == "Low") {
        echo "low-priority";
    } else if ($task->getPriority() == "Medium") {
        echo "medium-priority";
    } else if ($task->getPriority() == "High") {
        echo "high-priority";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/tables.css">
    <link rel="stylesheet" href="./assets/css/search_form.css">
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
                    <h1>Tasks</h1>
                    <?php
                    generateSearchForm($user, $db, $search_values);
                    ?>
                    <table>
                        <tr>
                            <th>
                                <a href="?<?php handleSort("id") ?>">Task ID
                                    <?php handleSortArrow("id") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("name") ?>">Task Name
                                    <?php handleSortArrow("name") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("start_date") ?>">Start Date
                                    <?php handleSortArrow("start_date") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("end_date") ?>">End Date
                                    <?php handleSortArrow("end_date") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("status") ?>">Status
                                    <?php handleSortArrow("status") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("priority") ?>">Priority
                                    <?php handleSortArrow("priority") ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?php handleSort("progress") ?>">Progress
                                    <?php handleSortArrow("progress") ?>
                                </a>
                            </th>
                            <th>Project Title - Project ID</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $sql = generateTaskSearchQuery($search_values, $user->getRole(), $sortOn, $sortOrder);
                        $db_tasks = $db->fetchAll($sql, $search_values);
                        $tasks = [];
                        foreach ($db_tasks as $db_task) {
                            $tasks[] = Task::fromArray($db_task);
                        }

                        foreach ($tasks as $task) {
                            if ($project != null && $task->getProjectId() != $project->getId())
                                continue;
                            ?>
                            <tr>
                                <td><?php echo $task->getId() ?></td>
                                <td><?php echo $task->getName() ?></td>
                                <td><?php echo $task->getStartDate() ?></td>
                                <td><?php echo $task->getEndDate() ?></td>
                                <td class="<?php getStatusClass($task) ?>"><?php echo $task->getStatus() ?></td>
                                <td class="<?php getPriorityClass($task) ?>"><?php echo $task->getPriority() ?></td>
                                <td><?php echo $task->getProgress() . "%" ?></td>
                                <?php
                                $taskProject = $db->fetchOne("SELECT id, title FROM project WHERE id = (SELECT project_id FROM task WHERE id = ?)", [$task->getId()]);
                                if ($taskProject != null) {
                                    echo "<td>" . $taskProject["title"] . " - " . $taskProject["id"] . "</td>";
                                } else {
                                    echo "<td>Unkown</td>";
                                }
                                ?>
                                <td>
                                    <?php if ($user->getRole() == "Project Leader") { ?>
                                        <a class="allocate-btn" href="./assign_member.php?tid=<?php echo $task->getId(); ?>">
                                            <img src="<?php echo $icons_path ?>/assign_member.png" alt="assign member image">
                                        </a>
                                    <?php } ?>
                                    <a class="allocate-btn" href="./task_details.php?tid=<?php echo $task->getId(); ?>">
                                        <img src="<?php echo $icons_path ?>/search_task.png" alt="search task image">
                                    </a>
                                    <?php if ($user->getRole() != "Manager") { ?>
                                        <a class="allocate-btn" href="./update_task.php?tid=<?php echo $task->getId(); ?>">
                                            <img src="<?php echo $icons_path ?>/edit.png" alt="edit task image">
                                        </a>
                                    <?php } ?>
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