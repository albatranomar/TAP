<?php
session_start();

require "./utils/utils.php";
require "./models/User.php";
require "./models/Address.php";
require "./models/Skill.php";

if (isset($_SESSION["user"])) {
    session_destroy();
    session_start();
}

// Progress:
// 1: User information form
// 2: E-Account Creation
// 3: Confimation And Submission
// 4: Completed
$progress = 1;
$new_user = null;
$is_post = $_SERVER["REQUEST_METHOD"] == "POST";
$errors = [];
$padded_user_id = "UNKNOWN";

if (isset($_SESSION["register_progress"])) {
    $progress = $_SESSION["register_progress"];

    if ($progress < 0 || $progress > 4) {
        $_SESSION["register_progress"] = 1;
        $_SESSION["new_user"] = null;
        $progress = 1;
    }
}

if (isset($_SESSION["new_user"])) {
    $new_user = unserialize($_SESSION["new_user"]);
}

if ($is_post) {
    if ($progress == 1) {
        $name = getPostField("name", $errors);
        $flat = getPostField("flat", $errors);
        $street = getPostField("street", $errors);
        $city = getPostField("city", $errors);
        $country = getPostField("country", $errors);
        $dob = getPostField("dob", $errors);
        $ssn = getPostField("ssn", $errors);
        $email = getPostField("email", $errors);
        $phone = getPostField("phone", $errors);
        $role = getPostField("role", $errors);
        $qualification = getPostField("qualification", $errors);
        $skills = getPostField("skills", $errors);

        if (count($errors) == 0) {
            $new_user = new User(null, $ssn, $name, $dob, $email, $phone, $role, $qualification, "null", "null");
            $_SESSION["new_user"] = serialize($new_user);
            $progress = 2;
            $_SESSION["register_progress"] = 2;

            $address = [];
            $address["country"] = $country;
            $address["city"] = $city;
            $address["street"] = $street;
            $address["flat"] = $flat;

            $_SESSION["address"] = $address;
            $_SESSION["skills"] = $skills;
        }
    } else if ($progress == 2) {
        $username = getPostField("username", $errors);
        $password = getPostField("password", $errors);
        $confirmPassword = getPostField("confirmPassword", $errors);

        if (!isset($errors["password"]) && !preg_match("/^[a-zA-Z0-9]{8,12}$/", $password)) {
            $errors["password"] = "Password must be 8–12 characters and contain letters/numbers.";
        } else if (!isset($errors["confirmPassword"]) && $password !== $confirmPassword) {
            $errors["confirmPassword"] = "Passwords must match.";
        }

        if (count($errors) == 0) {
            $new_user->setUsername($username);
            $new_user->setPassword($password);

            $_SESSION["new_user"] = serialize($new_user);
            $progress = 3;
            $_SESSION["register_progress"] = 3;
        }
    } else if ($progress == 3) {
        if ($new_user == null || !($new_user instanceof User)) {
            $errors[] = "Invalid User Missing Information!";
        } else if (!isset($_SESSION["address"])) {
            $errors[] = "Address is missing!";
        } else if (!isset($_SESSION["skills"])) {
            $errors[] = "Skills are missing!";
        } else {
            try {
                require_once("./db.inc.php");

                $new_user->save($db);
                $user_id = $db->lastInsertId();
                $padded_user_id = str_pad($user_id, 10, "0", STR_PAD_LEFT);

                $session_address = $_SESSION["address"];

                $address = new Address($user_id, $session_address["country"], $session_address["city"], $session_address["street"], $session_address["flat"]);
                $address->save($db);

                $skills = explode(",", $_SESSION["skills"]);

                foreach ($skills as $skill) {
                    $skill = trim($skill);
                    if (!empty($skill)) {
                        (new Skill($user_id, null, $skill))->save($db);
                    }
                }

                session_destroy();
                session_start();
            } catch (Throwable $e) {
                $errors[] = $e->getMessage();
            }
        }
        $progress = 4;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/register.css">
</head>

<body>
    <?php require_once "./layout/header.php" ?>

    <div class="container">
        <?php require_once "./layout/side_nav.php" ?>
        <main>
            <?php if ($progress == 1) {
                require_once("./layout/register/user_information_form.php");
                generateUserInfoForm($errors);
            } ?>

            <?php if ($progress == 2) {
                require_once("./layout/register/e_account_form.php");
                generateEAccountForm($errors);
            } ?>

            <?php if ($progress == 3) {
                require_once("./layout/register/confirmation.php");
                generateConfirmationForm($new_user, $_SESSION["address"], $_SESSION["skills"]);
            } ?>

            <?php if ($progress == 4) { ?>
                <?php if (count($errors) == 0) { ?>
                    <h1>You have been registered successfully 🎉</h1>
                    <p>User ID: <?php echo $padded_user_id ?></p><br>
                    <a class="go-to-login" href="./login.php">Go Login</a>
                <?php } else { ?>
                    <h1>Something went wrong ❌</h1>
                    <ul>
                        <?php foreach ($errors as $err) { ?>
                            <li class="error"><?php echo $err ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>