<?php

namespace NotSymfony\core;

use PDO;
use PDOException;

class DatabaseConnection
{
    public PDO $PDO;

    public function __construct(public string $host, string $username, string $password, public string $dbName)
    {
        $dsn = "mysql:host=$host;dbname=$dbName;charset=UTF8";

        try {
            $this->PDO = new PDO($dsn, $username, $password);
            $this->initializeTables();
        } catch (PDOException $e) {
            echo "Error in DB connection";
            echo $e->getMessage();
        }
    }

    public function initializeTables()
    {
        $statements = [
            "CREATE TABLE IF NOT EXISTS roles( 
              id   INT AUTO_INCREMENT,
              title  VARCHAR(100) NOT NULL, 
              privilege_level VARCHAR(20) NOT NULL,
              PRIMARY KEY(id)
            );",
            "CREATE TABLE IF NOT EXISTS user_role( 
              user_id  INT,
              role_id  INT, 
              PRIMARY KEY(user_id, role_id)
            );",
            "CREATE TABLE IF NOT EXISTS users( 
              id   INT AUTO_INCREMENT,
              username  VARCHAR(255) NOT NULL, 
              password VARCHAR(255) NOT NULL, 
              email   VARCHAR(255) NOT NULL,
              usd INT,
              PRIMARY KEY(id)
            );",
            "CREATE TABLE IF NOT EXISTS coins( 
              id   INT AUTO_INCREMENT,
              slug VARCHAR(10),
              user_id  INT, 
              amount FLOAT, 
              PRIMARY KEY(id)
            );"

        ];
        foreach ($statements as $statement) {
            $this->PDO->exec($statement);
        }

        if (!$this->PDO->query("SELECT COUNT(*) FROM `users`")->fetch()[0]) {
            $insertStatements = [
                "INSERT INTO roles VALUES (1, 'User', 2);",
                "INSERT INTO roles VALUES (2, 'Admin', 3);",
                "INSERT INTO users VALUES (1, 'admin','" .
                password_hash("password", PASSWORD_DEFAULT) .
                "', 'admin@admin.nl');",
                "INSERT INTO users VALUES (2, 'user', '" .
                password_hash("password", PASSWORD_DEFAULT) .
                "', 'user@user.nl');",
                "INSERT INTO user_role VALUES (1, 1);",
                "INSERT INTO user_role VALUES (1, 2);",
                "INSERT INTO user_role VALUES (2, 1);",
            ];

            foreach ($insertStatements as $statement) {
                $this->PDO->exec($statement);
            }
        }
    }

}