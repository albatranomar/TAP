<?php
class Document
{
    private ?int $document_id;
    private string $project_id;
    private string $title;

    public function __construct(?int $document_id, string $project_id, string $title)
    {
        $this->document_id = $document_id;
        $this->project_id = $project_id;
        $this->title = $title;
    }

    public function getDocumentId(): ?int
    {
        return $this->document_id;
    }

    public function setDocumentId(?int $document_id): void
    {
        $this->document_id = $document_id;
    }

    public function getProjectId(): string
    {
        return $this->project_id;
    }

    public function setProjectId(string $project_id): void
    {
        $this->project_id = $project_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public static function fromArray(array $data): Document
    {
        return new Document(
            isset($data['document_id']) ? (int) $data['document_id'] : null,
            $data['project_id'],
            $data['title']
        );
    }

    public static function findByProjectId(DatabaseHelper $databaseHelper, string $project_id): array
    {
        $db_documents = $databaseHelper->fetchAll(
            "SELECT * FROM `document` WHERE `project_id` = :project_id",
            ['project_id' => $project_id]
        );
        $documents = [];
        foreach ($db_documents as $db_document) {
            $documents[] = self::fromArray($db_document);
        }
        return $documents;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_documents = $databaseHelper->fetchAll("SELECT * FROM `document`");
        $documents = [];
        foreach ($db_documents as $db_document) {
            $documents[] = self::fromArray($db_document);
        }
        return $documents;
    }

    public function save(DatabaseHelper $databaseHelper): bool
    {
        $sql = $this->document_id === null
            ? "INSERT INTO `document` (project_id, title) VALUES (:project_id, :title)"
            : "UPDATE `document` SET title = :title WHERE document_id = :document_id";

        $params = $this->document_id === null
            ? ['project_id' => $this->project_id, 'title' => $this->title]
            : ['document_id' => $this->document_id, 'title' => $this->title];

        return $databaseHelper->execute($sql, $params);
    }

    public function delete(DatabaseHelper $databaseHelper): bool
    {
        $sql = "DELETE FROM `document` WHERE `document_id` = :document_id";
        return $databaseHelper->execute($sql, ['document_id' => $this->document_id]);
    }
}
?>