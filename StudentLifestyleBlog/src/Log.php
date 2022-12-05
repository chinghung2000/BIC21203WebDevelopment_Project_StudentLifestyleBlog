<?php

declare(strict_types=1);

class Log {
    private int $id;
    private string $operation;
    private string $description;
    public const OPERATION_REGISTER = "REGISTER";
    public const OPERATION_ADMIN_FAILED_LOGIN = "ADMIN_LOGIN";
    public const OPERATION_ADD_ADMIN = "ADD_ADMIN";
    public const OPERATION_UPDATE_ADMIN = "UPDATE_ADMIN";
    public const OPERATION_DELETE_ADMIN = "DELETE_ADMIN";
    public const OPERATION_ADMIN_DELETE_POST = "ADMIN_DELETE_POST";
    public const OPERATION_ADMIN_DELETE_COMMENT = "ADMIN_DELETE_COMMENT";
    public const OPERATION_FAILED_LOGIN = "LOGIN";
    public const OPERATION_UPDATE_PROFILE = "UPDATE_PROFILE";
    public const OPERATION_UPDATE_PASSWORD = "UPDATE_PASSWORD";
    public const OPERATION_ADD_POST = "ADD_POST";
    public const OPERATION_UPDATE_POST = "UPDATE_POST";
    public const OPERATION_DELETE_POST = "DELETE_POST";

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