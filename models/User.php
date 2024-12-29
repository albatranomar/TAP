<?php
class User
{
    private ?int $id;
    private string $ssn;
    private string $name;
    private string $dob;
    private string $email;
    private string $phone;
    private string $role;
    private string $qualification;
    private string $username;
    private string $password;
    private string $image;

    public function __construct(?int $id, $ssn, $name, $dob, $email, $phone, $role, $qualification, $username, $password, $image = 'user_profile.jpg')
    {
        $this->id = $id;
        $this->ssn = $ssn;
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

    public function getId(): ?string
    {
        if (is_null($this->id)) {
            return null;
        }

        return str_pad($this->id, 10, '0', STR_PAD_LEFT);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }

    public function setSsn(string $ssn)
    {
        $this->ssn = $ssn;
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
            isset($data['id']) ? (int) $data['id'] : null,
            $data['ssn'],
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

    public static function isUsernameAvailable(DatabaseHelper $db, string $username)
    {
        $stmt = $db->query("SELECT username FROM user WHERE username = :username", ["username" => $username]);

        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
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

    public function save(DatabaseHelper $databaseHelper)
    {
        $sql = $this->id === null
            ? "INSERT INTO `user` (name, dob, email, phone, role, qualification, username, password, image, ssn)
            VALUES (:name, :dob, :email, :phone, :role, :qualification, :username, :password, :image, :ssn)"
            : "UPDATE `user` SET name = :name, dob = :dob, email = :email, phone = :phone, role = :role, 
            qualification = :qualification, username = :username, password = :password, image = :image, ssn = :ssn WHERE id = :id";

        $params = [
            'name' => $this->name,
            'dob' => $this->dob,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'qualification' => $this->qualification,
            'username' => $this->username,
            'password' => $this->password,
            'image' => $this->image,
            'ssn' => $this->ssn
        ];

        if (!is_null($this->id)) {
            $params['id'] = $this->id;
        }

        return $databaseHelper->execute(
            $sql,
            $params
        );
    }

    public function delete(DatabaseHelper $databaseHelper)
    {
        $sql = "DELETE FROM `user` WHERE `id` = :id";
        return $databaseHelper->execute($sql, ['id' => $this->id]);
    }

}

?>