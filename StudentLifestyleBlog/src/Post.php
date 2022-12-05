<?php

declare(strict_types=1);
require_once "MySQL.php";
require_once "User.php";

class Post {
    private int $id;
    private User $user;
    private string $title;
    private DateTime $date;
    private string $type;
    private string $category;
    private string $content;

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["post_id"];
            $this->user = new User();
            $this->user->setId($r["user_id"]);
            $this->user->setUsername($r["username"]);
            $this->user->setAttemptLeft($r["attempt_left"]);
            $this->user->setName($r["user_name"]);
            $this->user->setEmail($r["user_email"]);
            $this->title = $r["post_title"];
            $this->date = date_create($r["post_date"]);
            $this->type = $r["post_type"];
            $this->category = $r["post_category"];
            $this->content = $r["post_content"];
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getDate(): DateTime {
        return $this->date;
    }

    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function setCategory(string $category): void {
        $this->category = $category;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }
}

?>