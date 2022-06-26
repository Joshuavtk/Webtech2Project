<?php

namespace NotSymfony\models;

use NotSymfony\core\App;

class User extends DatabaseModel
{
    public int $id = 0;
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public int $usd = 0;

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['username', 'email', 'password', 'usd'];
    }

    public function labels(): array
    {
        return [
            'username' => 'First name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Repeat password'
        ];
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [
                self::RULE_REQUIRED,
                self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE,
                    'class' => self::class
                ]
            ],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'password_repeat' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $success = parent::save();
        $this->id = App::$app->databaseConnection->PDO->lastInsertId();

        App::$app->databaseConnection->PDO->exec("INSERT INTO user_role VALUES (" . $this->id . ", 1);");
        return $success;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed|object|void
     */
    public static function login($email, $password)
    {
        $user = self::findOne(["email" => $email]);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        header("Location: ./login?error=incorrect_data");
        exit();
    }


    public function update()
    {
        $tableName = $this->tableName();
        $statement = self::prepare("UPDATE $tableName SET usd = :usd WHERE id=:user_id");
        $statement->bindValue(":usd", $this->usd);
        $statement->bindValue(":user_id", $this->id);
        $statement->execute();
    }
}