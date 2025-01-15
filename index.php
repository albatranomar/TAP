<?php
session_start();
require "./models/User.php";

$user = null;

if (isset($_SESSION["user"])) {
    $user = unserialize($_SESSION["user"]);
}

if ($user && $user instanceof User) {
    if ($user->getRole() == "Team Member") {
        header("Location: tasks.php");
    } else {
        header("Location: projects.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TAP</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/landing.css">
</head>

<body>
    <?php require_once "./layout/header.php" ?>

    <div class="container">
        <?php require_once "./layout/side_nav.php" ?>
        <main>
            <?php if (!$user) { ?>
                <h1>Welcome to TAP</h1>

                <div class="info">
                    <p><strong>Name:</strong> Omar Albatran</p>
                    <p><strong>ID:</strong> 1221344</p>
                    <a class="go-to-login" href="./login.php">Go Login</a>
                </div>

                <div class="user-table">
                    <h2>Table of Users</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>manager</td>
                                <td>manager1111</td>
                                <td>Manager</td>
                            </tr>
                            <tr>
                                <td>leader</td>
                                <td>leader1111</td>
                                <td>Team Leader</td>
                            </tr>
                            <tr>
                                <td>member1</td>
                                <td>member1111</td>
                                <td>Team Member</td>
                            </tr>
                            <tr>
                                <td>member2</td>
                                <td>member2222</td>
                                <td>Team Member</td>
                            </tr>
                            <tr>
                                <td>member3</td>
                                <td>member3333</td>
                                <td>Team Member</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </main>
    </div>

    <?php require_once "./layout/footer.php" ?>
</body>

</html>