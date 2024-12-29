<?php
class UserTask
{
    private string $user_id;
    private int $task_id;
    private string $role;
    private float $contribution;
    private bool $accepted;

    public function __construct(string $user_id, int $task_id, string $role, float $contribution, bool $accepted)
    {
        $this->user_id = $user_id;
        $this->task_id = $task_id;
        $this->role = $role;
        $this->contribution = $contribution;
        $this->accepted = $accepted;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getTaskId(): int
    {
        return $this->task_id;
    }

    public function setTaskId(int $task_id): void
    {
        $this->task_id = $task_id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getContribution(): float
    {
        return $this->contribution;
    }

    public function setContribution(float $contribution): void
    {
        $this->contribution = $contribution;
    }

    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): void
    {
        $this->accepted = $accepted;
    }

    public static function fromArray(array $data): UserTask
    {
        return new UserTask(
            $data['user_id'],
            (int) $data['task_id'],
            $data['role'],
            (float) $data['contribution'],
            (bool) $data['accepted']
        );
    }

    public static function findByTaskId(DatabaseHelper $databaseHelper, int $task_id): array
    {
        $db_user_tasks = $databaseHelper->fetchAll(
            "SELECT * FROM `user_task` WHERE `task_id` = :task_id",
            ['task_id' => $task_id]
        );
        $userTasks = [];
        foreach ($db_user_tasks as $db_user_task) {
            $userTasks[] = self::fromArray($db_user_task);
        }
        return $userTasks;
    }

    public static function findByUserId(DatabaseHelper $databaseHelper, string $user_id): array
    {
        $db_user_tasks = $databaseHelper->fetchAll(
            "SELECT * FROM `user_task` WHERE `user_id` = :user_id",
            ['user_id' => $user_id]
        );
        $userTasks = [];
        foreach ($db_user_tasks as $db_user_task) {
            $userTasks[] = self::fromArray($db_user_task);
        }
        return $userTasks;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_user_tasks = $databaseHelper->fetchAll("SELECT * FROM `user_task`");
        $userTasks = [];
        foreach ($db_user_tasks as $db_user_task) {
            $userTasks[] = self::fromArray($db_user_task);
        }
        return $userTasks;
    }

    public function save(DatabaseHelper $databaseHelper)
    {
        $sql = "
            INSERT INTO `user_task` (user_id, task_id, role, contribution, accepted)
            VALUES (:user_id, :task_id, :role, :contribution, :accepted)
            ON DUPLICATE KEY UPDATE
                role = VALUES(role),
                contribution = VALUES(contribution),
                accepted = VALUES(accepted)
        ";

        return $databaseHelper->execute($sql, [
            'user_id' => $this->user_id,
            'task_id' => $this->task_id,
            'role' => $this->role,
            'contribution' => $this->contribution,
            'accepted' => $this->accepted,
        ]);
    }

    public function delete(DatabaseHelper $databaseHelper)
    {
        $sql = "DELETE FROM `user_task` WHERE `user_id` = :user_id AND `task_id` = :task_id";
        return $databaseHelper->execute($sql, [
            'user_id' => $this->user_id,
            'task_id' => $this->task_id
        ]);
    }
}
?>