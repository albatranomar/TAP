<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Project.php";
require "./models/Document.php";

$icons_path = ROOT . "/assets/images/icons";

$user = null;
$project = null;
$error = null;
$successPost = false;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if (isset($_GET["pid"])) {
    $project = Project::findById($db, $_GET["pid"]);

    if (!$project) {
        header("Location: projects.php");
    }
} else {
    header("Location: projects.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["leader"]) && isset($_GET["pid"]) && $user && $user instanceof User && $user->getRole() == "Manager") {
        $project = Project::findById($db, $_GET["pid"]);
        if (!$project) {
            header("Location: projects.php");
            return;
        }

        $leader = User::findById($db, $_POST["leader"]);

        if (!$leader) {
            $error = "Invalid Leader Provided!";
        } else {
            $project->setTeamLeader($leader->getId());
            $project->save($db);
            $successPost = true;
        }
    } else {
        $error = "Invalid Leader Provided!";
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
                <?php if ($user->getRole() == "Manager") { ?>
                    <section class="form-container">
                        <h1>Allocate Team Leader</h1>
                        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
                            <div>
                                <label for="id">Project ID</label>
                                <input disabled type="text" id="id" value="<?php echo $project->getId() ?>">
                            </div>
                            <div>
                                <label for="title">Project Title</label>
                                <input disabled type="text" id="title" value="<?php echo $project->getTitle(); ?>">
                            </div>
                            <div class="full-width">
                                <label for="description">Project Description *</label>
                                <textarea disabled id="description"><?php echo $project->getDescription(); ?></textarea>
                            </div>
                            <div>
                                <label for="customer">Customer Name</label>
                                <input type="text" id="customer" disabled value="<?php echo $project->getCustomer(); ?>">
                            </div>
                            <div>
                                <label for="budget">Total Budget </label>
                                <input type="number" id="budget" disabled value="<?php echo $project->getBudget(); ?>">
                            </div>
                            <div>
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" disabled value="<?php echo $project->getStartDate(); ?>">
                            </div>
                            <div>
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" disabled value="<?php echo $project->getEndDate(); ?>">
                            </div>

                            <div>
                                <?php
                                $leaders = User::findAll($db);
                                ?>
                                <label for="leader">Team Leader</label>
                                <select id="leader" name="leader" required>
                                    <option selected disabled>Select Team Member</option>
                                    <?php foreach ($leaders as $leader) { ?>
                                        <?php if ($leader instanceof User && $leader->getRole() == "Project Leader") { ?>
                                            <option value="<?php echo $leader->getId() ?>">
                                                <?php echo $leader->getName() . ' - ' . $leader->getId() ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php if (!is_null($error)) { ?>
                                    <p class="error"><?php echo $error ?></p>
                                <?php } ?>
                            </div>

                            <div class="full-width">
                                <button type="submit">Confirm Allocation</button>
                            </div>
                        </form>
                        <?php if ($successPost) { ?>
                            <p class="success">Project Leader successfully allocated</p>
                        <?php } ?>
                    </section>
                    <section>
                        <h1>Documents</h1>
                        <ul>
                            <?php
                            $docs = Document::findByProjectId($db, $project->getId());
                            foreach ($docs as $doc) { ?>
                                <?php if ($doc instanceof Document) { ?>
                                    <li><a class="document-link"
                                            href="./assets/uploaded_documents/<?php echo $doc->getTitle(); ?>"><?php echo $doc->getTitle() ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
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