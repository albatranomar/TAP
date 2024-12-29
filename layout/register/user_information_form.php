<?php
function generateUserInfoForm(array $errors)
{
    require_once "config.inc.php";
    require_once "db.inc.php";
    $roles = $db->getEnumValues('user', 'role');

    ?>
    <div class="form-container">
        <h2>User Information Form</h2>
        <form action="<?php echo ROOT ?>/register.php" method="POST">
            <div class="form-group">
                <label for="name" class="required">Full Name *</label>
                <input type="text" id="name" name="name" required>
                <?php if (isset($errors['name'])) {
                    echo '<p class="error">' . $errors['name'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="flat" class="required">Flat/House No *</label>
                <input type="text" id="flat" name="flat" required>
                <?php if (isset($errors['flat'])) {
                    echo '<p class="error">' . $errors['flat'] . '</p>';
                } ?>
            </div>
            <div class="form-group">
                <label for="street" class="required">Street *</label>
                <input type="text" id="street" name="street" required>
                <?php if (isset($errors['street'])) {
                    echo '<p class="error">' . $errors['street'] . '</p>';
                } ?>
            </div>
            <div class="form-group">
                <label for="city" class="required">City *</label>
                <input type="text" id="city" name="city" required>
                <?php if (isset($errors['city'])) {
                    echo '<p class="error">' . $errors['city'] . '</p>';
                } ?>
            </div>
            <div class="form-group">
                <label for="country" class="required">Country *</label>
                <input type="text" id="country" name="country" required>
                <?php if (isset($errors['country'])) {
                    echo '<p class="error">' . $errors['country'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="dob" class="required">Date of Birth *</label>
                <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required>
                <?php if (isset($errors['dob'])) {
                    echo '<p class="error">' . $errors['dob'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="ssn" class="required">Social Security Number *</label>
                <input type="text" id="ssn" name="ssn" maxlength="9" pattern="\d{9}" inputmode="numeric"
                    title="SSN must be exactly 9 digits" required>
                <?php if (isset($errors['ssn'])) {
                    echo '<p class="error">' . $errors['ssn'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="email" class="required">E-mail Address *</label>
                <input type="email" id="email" name="email" required>
                <?php if (isset($errors['email'])) {
                    echo '<p class="error">' . $errors['email'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="phone" class="required">Telephone *</label>
                <input type="tel" id="phone" name="phone" maxlength="10" required>
                <?php if (isset($errors['phone'])) {
                    echo '<p class="error">' . $errors['phone'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="role" class="required">Role *</label>
                <select id="role" name="role" required>
                    <option value="" selected disabled>Select Role</option>
                    <?php foreach ($roles as $role) { ?>
                        <option value="<?php echo $role ?>"><?php echo $role ?></option>
                    <?php } ?>
                </select>
                <?php if (isset($errors['role'])) {
                    echo '<p class="error">' . $errors['role'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="qualification" class="required">Qualification *</label>
                <input type="text" id="qualification" name="qualification" required>
                <?php if (isset($errors['qualification'])) {
                    echo '<p class="error">' . $errors['qualification'] . '</p>';
                } ?>
            </div>

            <div class="form-group">
                <label for="skills" class="required">Skills *</label>
                <input type="text" id="skills" name="skills" placeholder="Seprate by comma ," required>
                <?php if (isset($errors['skills'])) {
                    echo '<p class="error">' . $errors['skills'] . '</p>';
                } ?>
            </div>

            <button type="submit">Proceed</button>
        </form>
    </div>
<?php } ?>