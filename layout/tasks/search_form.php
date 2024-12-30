<?php
function generateSearchForm(User $user, DatabaseHelper $db, array $values)
{
    ?>
    <form class="search-form">
        <div class="form-group">
            <label for="task-id">Task ID</label>
            <input type="text" id="id" name="id" placeholder="Enter Task ID"
                value="<?php echo isset($values["id"]) ? $values["id"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="name">Task Name</label>
            <input type="text" id="name" name="name" placeholder="Enter Task Name"
                value="<?php echo isset($values["name"]) ? $values["name"] : "" ?>">
        </div>
        <div class="form-group">
            <?php
            $db_projects = [];

            if ($user->getRole() == "Manager") {
                $db_projects = $db->fetchAll("SELECT * FROM project");
            } else if ($user->getRole() == "Project Leader") {
                $db_projects = $db->fetchAll("SELECT * FROM project WHERE team_leader = ?", [$user->getId()]);
            } else if ($user->getRole() == "Team Member") {
                $db_projects = $db->fetchAll("SELECT DISTINCT p.* FROM user_task ut
                                                                        JOIN task t ON ut.task_id = t.id
                                                                        JOIN project p ON t.project_id = p.id
                                                                        WHERE ut.user_id = ?", [$user->getId()]);
            }
            ?>
            <label for="pid">Project</label>
            <select id="pid" name="pid">
                <option <?php echo isset($values["project"]) ? "" : "selected" ?> disabled>Select Project</option>
                <?php foreach ($db_projects as $db_project) { ?>
                    <?php if ($values["project"] && $values["project"] instanceof Project && $values["project"]->getId() == $db_project["id"]) { ?>
                        <option selected value="<?php echo $db_project["id"] ?>">
                            <?php echo $db_project["title"] . ' - ' . $db_project["id"] ?>
                        </option>
                    <?php } else { ?>
                        <option value="<?php echo $db_project["id"] ?>">
                            <?php echo $db_project["title"] . ' - ' . $db_project["id"] ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="priority">Task Priority</label>
            <select id="priority" name="priority" required>
                <option <?php echo isset($values["priority"]) ? "" : "selected" ?> disabled>Select Priority</option>
                <?php foreach ($db->getEnumValues("task", "priority") as $priority) { ?>
                    <option <?php echo isset($values["priority"]) && $values["priority"] == $priority ? "selected" : "" ?>
                        value="<?php echo $priority ?>">
                        <?php echo $priority ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Task Status</label>
            <select id="status" name="status" required>
                <option <?php echo isset($values["status"]) ? "" : "selected" ?> disabled>Select Status</option>
                <?php foreach ($db->getEnumValues("task", "status") as $status) { ?>
                    <option <?php echo isset($values["status"]) && $values["status"] == $status ? "selected" : "" ?>
                        value="<?php echo $status ?>">
                        <?php echo $status ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date"
                value="<?php echo isset($values["start_date"]) ? $values["start_date"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date"
                value="<?php echo isset($values["end_date"]) ? $values["end_date"] : "" ?>">
        </div>

        <button type="submit">Search</button>
    </form>
<?php } ?>