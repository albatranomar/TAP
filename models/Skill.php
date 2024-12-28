<?php
class Skill
{
    private string $user_id;
    private int $skill_id;
    private string $skill;

    public function __construct(string $user_id, int $skill_id, string $skill)
    {
        $this->user_id = $user_id;
        $this->skill_id = $skill_id;
        $this->skill = $skill;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getSkillId(): int
    {
        return $this->skill_id;
    }

    public function setSkillId(int $skill_id): void
    {
        $this->skill_id = $skill_id;
    }

    public function getSkill(): string
    {
        return $this->skill;
    }

    public function setSkill(string $skill): void
    {
        $this->skill = $skill;
    }

    public static function fromArray(array $data): Skill
    {
        return new Skill(
            $data['user_id'],
            (int) $data['skill_id'],
            $data['skill']
        );
    }

    public static function findByUserId(DatabaseHelper $databaseHelper, string $user_id): array
    {
        $db_skills = $databaseHelper->fetchAll("SELECT * FROM `skill` WHERE `user_id` = :user_id", ['user_id' => $user_id]);
        $skills = [];

        foreach ($db_skills as $db_skill) {
            $skills[] = self::fromArray($db_skill);
        }

        return $skills;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_skills = $databaseHelper->fetchAll("SELECT * FROM `skill`");
        $skills = [];

        foreach ($db_skills as $db_skill) {
            $skills[] = self::fromArray($db_skill);
        }

        return $skills;
    }

    public function save(DatabaseHelper $databaseHelper): bool
    {
        $sql = "
            INSERT INTO `skill` (user_id, skill_id, skill)
            VALUES (:user_id, :skill_id, :skill)
            ON DUPLICATE KEY UPDATE
                skill = VALUES(skill)
        ";

        return $databaseHelper->execute($sql, [
            'user_id' => $this->user_id,
            'skill_id' => $this->skill_id,
            'skill' => $this->skill,
        ]);
    }

    public function delete(DatabaseHelper $databaseHelper): bool
    {
        $sql = "DELETE FROM `skill` WHERE `skill_id` = :skill_id";
        return $databaseHelper->execute($sql, ['skill_id' => $this->skill_id]);
    }
}

?>