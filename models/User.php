<?php
class User
{
    private string $id;
    private string $name;
    private string $dob;
    private string $email;
    private string $phone;
    private string $role;
    private string $qualification;
    private string $username;
    private string $password;
    private string $image;

    public function __construct($id, $name, $dob, $email, $phone, $role, $qualification, $username, $password, $image = 'user_profile.jpg')
    {
        $this->id = $id;
        $this->name = $name;
        $this->dob = $dob;
        $this->email = $email;
        $this->phone = $phone;
        $this->role = $role;
        $this->qualification = $qualification;
        $this->username = $username;
        $this->password = $password;
        $this->image = $image;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
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

    public function getDob(): string
    {
        return $this->dob;
    }

    public function setDob(string $dob): void
    {
        $this->dob = $dob;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): void
    {
        $this->qualification = $qualification;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getAddress(DatabaseHelper $databaseHelper): Address
    {
        return Address::findById($databaseHelper, $this->id);
    }

    public function getSkills(DatabaseHelper $databaseHelper): array
    {
        return Skill::findByUserId($databaseHelper, $this->id);
    }

    public static function fromArray(array $data): User
    {
        return new User(
            $data['id'],
            $data['name'],
            $data['dob'],
            $data['email'],
            $data['phone'],
            $data['role'],
            $data['qualification'],
            $data['username'],
            $data['password'],
            $data['image'] ?? 'user_profile.jpg'
        );
    }

    public static function findById(DatabaseHelper $databaseHelper, string $id): ?User
    {
        $user = $databaseHelper->fetchOne("SELECT * FROM `user` WHERE `id` = :id", ['id' => $id]);

        return $user ? self::fromArray($user) : null;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_users = $databaseHelper->fetchAll("SELECT * FROM `user`");
        $users = [];

        foreach ($db_users as $db_user) {
            $users[] = self::fromArray($db_user);
        }

        return $users;
    }

    public function save(DatabaseHelper $databaseHelper): bool
    {
        $sql = "
            INSERT INTO `user` (id, name, dob, email, phone, role, qualification, username, password, image)
            VALUES (:id, :name, :dob, :email, :phone, :role, :qualification, :username, :password, :image)
            ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                dob = VALUES(dob),
                email = VALUES(email),
                phone = VALUES(phone),
                role = VALUES(role),
                qualification = VALUES(qualification),
                username = VALUES(username),
                password = VALUES(password),
                image = VALUES(image)
        ";

        return $databaseHelper->execute(
            $sql,
            [
                'id' => $this->id,
                'name' => $this->name,
                'dob' => $this->dob,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'qualification' => $this->qualification,
                'username' => $this->username,
                'password' => $this->password,
                'image' => $this->image,
            ]
        );
    }

    public function delete(DatabaseHelper $databaseHelper): bool
    {
        $sql = "DELETE FROM `user` WHERE `id` = :id";
        return $databaseHelper->execute($sql, ['id' => $this->id]);
    }
}

?>