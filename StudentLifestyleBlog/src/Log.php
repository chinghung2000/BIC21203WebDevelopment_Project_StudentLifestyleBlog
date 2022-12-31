<?php

declare(strict_types=1);

class Log {
    private int $id;
    private string $operation;
    private string $description;
    public const OPERATION_REGISTER = "REGISTER";
    public const OPERATION_FAILED_LOGIN = "FAILED_LOGIN";
    public const OPERATION_UPDATE_PASSWORD = "UPDATE_PASSWORD";
    public const OPERATION_INSERT = "INSERT";
    public const OPERATION_UPDATE = "UPDATE";
    public const OPERATION_DELETE = "DELETE";

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["log_id"];
            $this->operation = $r["operation"];
            $this->description = $r["description"];
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getOperation(): string {
        return $this->operation;
    }

    public function setOperation(string $operation): void {
        $this->operation = $operation;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }
}

?>