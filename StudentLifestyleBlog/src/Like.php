<?php

declare(strict_types=1);
require_once "Post.php";
require_once "User.php";

class Like {
    private int $id;
    private Post $post;
    private User $user;
    private DateTime $timestamp;

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["like_id"];
            $this->post = new Post();
            $this->post->setId($r["post_id"]);
            $this->post->setTitle($r["post_title"]);
            $this->post->setDate($r["post_date"]);
            $this->post->setType($r["post_type"]);
            $this->post->setCategory($r["post_category"]);
            $this->post->setContent($r["post_content"]);
            $this->user = new User();
            $this->user->setId($r["user_id"]);
            $this->user->setUsername($r["username"]);
            $this->user->setAttemptLeft($r["attempt_left"]);
            $this->user->setName($r["user_name"]);
            $this->user->setEmail($r["user_email"]);
            $this->timestamp = date_create($r["like_timestamp"]);
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getPost(): Post {
        return $this->post;
    }

    public function setPost(Post $post): void {
        $this->post = $post;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }

    public function getTimestamp(): DateTime {
        return $this->timestamp;
    }

    public function setTimestamp(DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }
}

?>