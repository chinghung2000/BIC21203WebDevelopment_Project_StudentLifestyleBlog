<?php

declare(strict_types=1);

class MySQL {
    private string $hostName = "localhost";
    private string $database = "blogsys";
    private string $username = "appuser";
    private string $password = "1234";

    public function connect(): mysqli|false {
        try {
            return new mysqli($this->hostName, $this->username, $this->password, $this->database);
        } catch (mysqli_sql_exception $e) {
        }

        return false;
    }
}

?>