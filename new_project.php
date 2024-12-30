<?php
session_start();
require "./db.inc.php";
require "./config.inc.php";
require "./models/User.php";
require "./models/Project.php";
require "./models/Document.php";
require "./utils/utils.php";

$user = null;
$errors = [];
$successPost = false;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user && $user instanceof User && $user->getRole() == "Manager") {
    $id = getPostField("id", $errors);
    $title = getPostField("title", $errors);
    $description = getPostField("description", $errors);
    $customer = getPostField("customer", $errors);
    $budget = getPostField("budget", $errors);
    $start_date = getPostField("start_date", $errors);
    $end_date = getPostField("end_date", $errors);
    $files = [];

    if (count($errors) == 0) {
        if (!preg_match('/^[A-Z]{4}-\d{5}$/', $id)) {
            $errors["id"] = 'Invalid id format!';
        } else if (!Project::isIdAvailable($db, $id)) {
            $errors["id"] = 'This ID[' . $id . '] alreay exists!';
        }

        if (strtotime($start_date) <= strtotime(date('Y-m-d'))) {
            $errors["start_date"] = "Start Date must be greater than today!";
        }

        if (strtotime($end_date) <= strtotime($start_date)) {
            $errors["end_date"] = "End Date must be later than Start Date!";
        }

        if (!is_numeric($budget) || ((float) $budget) <= 0) {
            $errors["budget"] = "Total Budget must be a positive numeric value!";
        }

        if (isset($_FILES["files"])) {
            $files = $_FILES["files"];

            if (count($files['name']) > 3) {
                $errors["files[]"] = "Maximum 3 documents!";
            }
        }

        if (count($errors) == 0) {
            $allowedTypes = ['pdf', 'docx', 'png', 'jpeg'];
            $maxSize = 2 * 1024 * 1024;

            for ($i = 0; $i < count($files['name']); $i++) {
                $fileName = $files['name'][$i];
                $fileSize = $files['size'][$i];
                $tmpName = $files['tmp_name'][$i];
                $fileError = $files['error'][$i];

                $parts = explode('.', $fileName);
                $fileExtension = strtolower(end($parts));

                if ($fileName == '')
                    continue;

                if (!in_array($fileExtension, $allowedTypes)) {
                    $errors['files[]'] = "Invalid file type for '$fileName'. Allowed types are PDF, DOCX, PNG, JPG.";
                    break;
                }

                if ($fileSize > $maxSize) {
                    $errors["files[]"] = "File '$fileName' exceeds the maximum size of 2MB!";
                    break;
                }
            }

            if (count($errors) == 0) {
                try {
                    $project = new Project($id, $title, $description, $customer, $budget, $start_date, $end_date, $user->getId());
                    $project->save($db);

                    for ($i = 0; $i < count($files['name']); $i++) {
                        $fileName = $files['name'][$i];
                        $tmpName = $files['tmp_name'][$i];

                        $uploadDir = "assets/uploaded_documents/";
                        $destination = $uploadDir . basename($fileName);

                        if (move_uploaded_file($tmpName, $destination)) {
                            $doc = new Document(null, $id, $fileName);
                            $doc->save($db);
                        }
                    }

                    $successPost = true;
                } catch (Exception $e) {
                    $errors["db"] = $e->getMessage();
                }
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
                <?php if ($user->getRole() == "Manager") { ?>
                    <section class="form-container">
                        <h1>Create a Project</h1>
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                            <div>
                                <label for="id">Project ID *</label>
                                <input type="text" id="id" name="id" placeholder="e.g. ABCD-12345" pattern="^[A-Z]{4}-\d{5}$"
                                    required>
                                <?php if (isset($errors['id'])) {
                                    echo '<p class="error">' . $errors['id'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="title">Project Title *</label>
                                <input type="text" id="title" name="title" required>
                                <?php if (isset($errors['title'])) {
                                    echo '<p class="error">' . $errors['title'] . '</p>';
                                } ?>
                            </div>
                            <div class="full-width">
                                <label for="description">Project Description *</label>
                                <textarea id="description" name="description" required></textarea>
                                <?php if (isset($errors['description'])) {
                                    echo '<p class="error">' . $errors['description'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="customer">Customer Name *</label>
                                <input type="text" id="customer" name="customer" required>
                                <?php if (isset($errors['customer'])) {
                                    echo '<p class="error">' . $errors['customer'] . '</p>';
                                } ?>
                            </div>
                            <div>
                                <label for="budget">Total Budget *</label>
                                <input type="number" id="budget" name="budget" min="1" step="0.01" required>
                                <?php if (isset($errors['budget'])) {
                                    echo '<p class="error">' . $errors['budget'] . '</p>';
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
                            <div class="full-width">
                                <label>Supporting Documents</label>
                                <input type="file" id="files" name="files[]" accept=".pdf,.docx,.png,.jpg" multiple>
                                <?php if (isset($errors['files[]'])) {
                                    echo '<p class="error">' . $errors['files[]'] . '</p>';
                                } ?>
                            </div>
                            <div class="full-width">
                                <button type="submit">Submit</button>
                            </div>
                            <?php if ($successPost) { ?>
                                <p class="success">Project successfully added</p>
                            <?php } else if (isset($errors["db"])) {
                                echo '<p class="error">' . $errors['db'] . '</p>';
                            } ?>
                        </form>
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