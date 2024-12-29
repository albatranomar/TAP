<?php
function generateConfirmationForm(User $user, array $address, string $skills = "")
{
    require_once "config.inc.php";
    ?>
    <div class="form-container">
        <h2>Confirmation Form</h2>
        <form action="<?php echo ROOT ?>/register.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" value="<?php echo $user->getName() ?>" disabled>
            </div>

            <div class="form-group">
                <label for="flat">Address</label>
                <input type="text" id="flat"
                    value="<?php echo $address["flat"] . ", " . $address["street"] . ", " . $address["city"] . ", " . $address["country"] ?>"
                    disabled>
            </div>
            <div class="form-group">
                <label for="dom">Date of Birth</label>
                <input type="text" id="dob" value="<?php echo $user->getDob() ?>" disabled>
            </div>
            <div class="form-group">
                <label for="ssn">Social Security Number</label>
                <input type="text" id="ssn" value="<?php echo $user->getDob() ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" value="<?php echo $user->getEmail() ?>" disabled>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" id="role" value="<?php echo $user->getRole() ?>" disabled>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" value="<?php echo $user->getPhone() ?>" disabled>
            </div>

            <div class="form-group">
                <label for="qualification">Qualification *</label>
                <input type="text" id="qualification" value="<?php echo $user->getQualification() ?>" disabled>
            </div>

            <div class="form-group">
                <label for="skills">Skills *</label>
                <input type="text" id="skills" value="<?php echo $skills ?>" disabled>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" value="<?php echo $user->getUsername() ?>" disabled>
            </div>

            <button type="submit">Confirm</button>
        </form>
    </div>
<?php } ?>