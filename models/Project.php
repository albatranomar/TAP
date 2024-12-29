<?php
class Project
{
    private string $id;
    private string $title;
    private string $description;
    private string $customer;
    private float $budget;
    private string $start_date;
    private string $end_date;
    private ?string $manager;
    private ?string $team_leader;

    public function __construct(
        string $id,
        string $title,
        string $description,
        string $customer,
        float $budget,
        string $start_date,
        string $end_date,
        ?string $manager = null,
        ?string $team_leader = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->customer = $customer;
        $this->budget = $budget;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->manager = $manager;
        $this->team_leader = $team_leader;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCustomer(): string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): void
    {
        $this->budget = $budget;
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

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(?string $manager): void
    {
        $this->manager = $manager;
    }

    public function getTeamLeader(): ?string
    {
        return $this->team_leader;
    }

    public function setTeamLeader(?string $team_leader): void
    {
        $this->team_leader = $team_leader;
    }

    public function getDocuments(DatabaseHelper $databaseHelper): array
    {
        return Document::findByProjectId($databaseHelper, $this->id);
    }

    public static function fromArray(array $data): Project
    {
        return new Project(
            $data['id'],
            $data['title'],
            $data['description'],
            $data['customer'],
            (float) $data['budget'],
            $data['start_date'],
            $data['end_date'],
            $data['manager'] ?? null,
            $data['team_leader'] ?? null
        );
    }

    public static function findById(DatabaseHelper $databaseHelper, string $id): ?Project
    {
        $db_project = $databaseHelper->fetchOne("SELECT * FROM `project` WHERE `id` = :id", ['id' => $id]);
        if ($db_project) {
            return self::fromArray($db_project);
        }
        return null;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_projects = $databaseHelper->fetchAll("SELECT * FROM `project`");
        $projects = [];
        foreach ($db_projects as $db_project) {
            $projects[] = self::fromArray($db_project);
        }
        return $projects;
    }

    public function save(DatabaseHelper $databaseHelper)
    {
        $sql = "
            INSERT INTO `project` (id, title, description, customer, budget, start_date, end_date, manager, team_leader)
            VALUES (:id, :title, :description, :customer, :budget, :start_date, :end_date, :manager, :team_leader)
            ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                description = VALUES(description),
                customer = VALUES(customer),
                budget = VALUES(budget),
                start_date = VALUES(start_date),
                end_date = VALUES(end_date),
                manager = VALUES(manager),
                team_leader = VALUES(team_leader)
        ";

        return $databaseHelper->execute($sql, [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'customer' => $this->customer,
            'budget' => $this->budget,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'manager' => $this->manager,
            'team_leader' => $this->team_leader,
        ]);
    }

    public function delete(DatabaseHelper $databaseHelper)
    {
        $sql = "DELETE FROM `project` WHERE `id` = :id";
        return $databaseHelper->execute($sql, ['id' => $this->id]);
    }
}
?>