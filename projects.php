<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Project.php";

$icons_path = ROOT . "/assets/images/icons";

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
                <?php if ($user->getRole() != "Team Member") { ?>
                    <section class="form-container">
                        <h1>Projects</h1>
                        <table>
                            <tr>
                                <th>Project ID</th>
                                <th>Project Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $db_unassigned_projects = $db->fetchAll("SELECT * FROM `project` WHERE team_leader IS NULL");
                            $db_assigned_projects = $db->fetchAll("SELECT * FROM `project` WHERE team_leader IS NOT NULL");
                            $projects = [];
                            foreach ($db_unassigned_projects as $db_project) {
                                $projects[] = Project::fromArray($db_project);
                            }
                            foreach ($db_assigned_projects as $db_project) {
                                $projects[] = Project::fromArray($db_project);
                            }

                            foreach ($projects as $project) { ?>
                                <tr>
                                    <td><?php echo $project->getId() ?></td>
                                    <td><?php echo $project->getTitle() ?></td>
                                    <td><?php echo $project->getStartDate() ?></td>
                                    <td><?php echo $project->getEndDate() ?></td>
                                    <?php if ($project->getTeamLeader() == null) { ?>
                                        <?php if ($user->getRole() == "Manager") { ?>
                                            <td><a class="allocate-btn" href="./assign_leader.php?pid=<?php echo $project->getId(); ?>"><img
                                                        src="<?php echo $icons_path ?>/assign_leader.png" alt="assign leader image">
                                                    Allocate Team Leader</a></td>
                                        <?php } else { ?>
                                            <td>Not Allowed</td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <td>Already allocated</td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </section>
                <?php } else { ?>
                    <h1>Access Denied!</h1>
                    <p>only can be accessed by a manager!</p>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>