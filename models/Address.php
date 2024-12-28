<?php
class Address
{
    private string $user_id;
    private string $country;
    private string $city;
    private string $street;
    private string $flat;

    public function __construct(
        string $user_id = '',
        string $country = '',
        string $city = '',
        string $street = '',
        string $flat = ''
    ) {
        $this->user_id = $user_id;
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->flat = $flat;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getFlat(): string
    {
        return $this->flat;
    }

    public function setFlat(string $flat): void
    {
        $this->flat = $flat;
    }

    public static function fromArray(array $data): Address
    {
        return new Address(
            $data['user_id'],
            $data['country'],
            $data['city'],
            $data['street'],
            $data['flat']
        );
    }

    public static function findById(DatabaseHelper $databaseHelper, string $user_id): ?Address
    {
        $address = $databaseHelper->fetchOne("SELECT * FROM `address` WHERE `user_id` = :user_id", ['user_id' => $user_id]);

        return $address ? self::fromArray($address) : null;
    }

    public static function findAll(DatabaseHelper $databaseHelper): array
    {
        $db_addresses = $databaseHelper->fetchAll("SELECT * FROM `address`");
        $addresses = [];

        foreach ($db_addresses as $db_address) {
            $addresses[] = self::fromArray($db_address);
        }

        return $addresses;
    }

    public function save(DatabaseHelper $databaseHelper): bool
    {
        $sql = "
            INSERT INTO `address` (user_id, country, city, street, flat)
            VALUES (:user_id, :country, :city, :street, :flat)
            ON DUPLICATE KEY UPDATE
                country = VALUES(country),
                city = VALUES(city),
                street = VALUES(street),
                flat = VALUES(flat)
        ";

        return $databaseHelper->execute($sql, [
            'user_id' => $this->user_id,
            'country' => $this->country,
            'city' => $this->city,
            'street' => $this->street,
            'flat' => $this->flat,
        ]);
    }
}


?>