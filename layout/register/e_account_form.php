<?php
function generateEAccountForm(array $errors)
{
    require_once "config.inc.php";

    ?>
    <div class="form-container">
        <h2>E-Account</h2>
        <form action="<?php echo ROOT ?>/register.php" method="POST">
            <div class="form-group">
                <label for="username">Username (6-13 characters)</label>
                <input type="text" id="username" name="username" required>
                <?php if (isset($errors['username'])) {
                    echo '<p class="error">' . $errors['username'] . '</p>';
                } ?>
            </div>
            <div class="form-group">
                <label for="password">Password (8-12 characters, letters/numbers)</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])) {
                    echo '<p class="error">' . $errors['password'] . '</p>';
                } ?>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <?php if (isset($errors['confirmPassword'])) {
                    echo '<p class="error">' . $errors['confirmPassword'] . '</p>';
                } ?>
            </div>
            <button type="submit">Proceed to Confirmation</button>
        </form>
    </div>
<?php } ?>