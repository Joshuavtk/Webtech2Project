<?php

namespace NotSymfony\models;

class Coin extends DatabaseModel
{
    public int $id = 0;
    public string $slug = '';
    public string $user_id = '';
    public float $amount = 0;

    public static function tableName(): string
    {
        return 'coins';
    }

    public function attributes(): array
    {
        return ['slug', 'user_id', 'amount'];
    }

    public function labels(): array
    {
        return [
            'slug' => 'slug',
            'user_id' => 'User id',
            'amount' => 'Amount'
        ];
    }

    public function rules(): array
    {
        return [
            'slug' => [self::RULE_REQUIRED],
            'user_id' => [self::RULE_REQUIRED],
            'amount' => [self::RULE_REQUIRED],
        ];
    }


    public function update()
    {
        $tableName = $this->tableName();
        $statement = self::prepare("UPDATE $tableName SET amount = :amount WHERE slug=:slug AND user_id=:user_id");
        $statement->bindValue(":amount", $this->amount);
        $statement->bindValue(":slug", $this->slug);
        $statement->bindValue(":user_id", $this->user_id);
        $statement->execute();
    }

}