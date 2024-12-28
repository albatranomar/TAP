<?php
class Task
{
    private ?int $id;
    private string $name;
    private string $description;
    private string $project_id;
    private string $start_date;
    private string $end_date;
    private float $effort;
    private string $status;
    private string $priority;
    private float $progress;

    public function __construct(
        ?int $id,
        string $name,
        string $description,
        string $project_id,
        string $start_date,
        string $end_date,
        float $effort,
        string $status,
        string $priority,
        float $progress
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->project_id = $project_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->effort = $effort;
        $this->status = $status;
        $this->priority = $priority;
        $this->progress = $progress;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getProjectId(): string
    {
        return $this->project_id;
    }

    public function setProjectId(string $project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getStartDate(): string
    {
        return $this->start_date;
    }

    public function setStartDate(string $start_date): void
    {
        $this->start_date = $start_date;
    }

    public function getEndDate(): string
    {
        return $this->end_date;
    }

    public function setEndDate(string $end_date): void
    {
        $this->end_date = $end_date;
    }

    public function getEffort(): float
    {
        return $this->effort;
    }

    public function setEffort(float $effort): void
    {
        $this->effort = $effort;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

    public function getProgress(): float
    {
        return $this->progress;
    }

    public function setProgress(float $progress): void
    {
        $this->progress = $progress;
    }

    public static function fromArray(array $data): Task
    {
        return new Task(
            isset($data['id']) ? (int) $data['id'] : null,
            $data['name'],
            $data['description'],
            $data['project_id'],
            $data['start_date'],
            $data['end_date'],
            (float) $data['effort'],
            $data['status'],
            $data['priority'],
            (float) $data['progress']
        );
    }

    public static function findByProjectId(DatabaseHelper $databaseHelper, string $project_id): array
    {
        $db_tasks = $databaseHelper->fetchAll(
            "SELECT * FROM `task` WHERE `project_id` = :project_id",
            ['project_id' => $project_id]
        );
        $tasks = [];
        foreach ($db_tasks as $db_task) {
            $tasks[] = self::fromArray($db_task);
        }
        return $tasks;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_tasks = $databaseHelper->fetchAll("SELECT * FROM `task`");
        $tasks = [];
        foreach ($db_tasks as $db_task) {
            $tasks[] = self::fromArray($db_task);
        }
        return $tasks;
    }

    public function save(DatabaseHelper $databaseHelper): bool
    {
        $sql = $this->id === null
            ? "INSERT INTO `task` (name, description, project_id, start_date, end_date, effort, status, priority, progress) 
                VALUES (:name, :description, :project_id, :start_date, :end_date, :effort, :status, :priority, :progress)"
            : "UPDATE `task` SET name = :name, description = :description, project_id = :project_id, 
                start_date = :start_date, end_date = :end_date, effort = :effort, 
                status = :status, priority = :priority, progress = :progress WHERE id = :id";

        $params = $this->id === null
            ? [
                'name' => $this->name,
                'description' => $this->description,
                'project_id' => $this->project_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'effort' => $this->effort,
                'status' => $this->status,
                'priority' => $this->priority,
                'progress' => $this->progress,
            ]
            : [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'project_id' => $this->project_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'effort' => $this->effort,
                'status' => $this->status,
                'priority' => $this->priority,
                'progress' => $this->progress,
            ];

        return $databaseHelper->execute($sql, $params);
    }

    public function delete(DatabaseHelper $databaseHelper): bool
    {
        $sql = "DELETE FROM `task` WHERE `id` = :id";
        return $databaseHelper->execute($sql, ['id' => $this->id]);
    }
}
