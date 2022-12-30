<?php

declare(strict_types=1);
require_once("User.php");
require_once("Post.php");
require_once("Comment.php");

class Report {
    private int $id;
    private User $user;
    private Post $post;
    private Comment $comment;
    private DateTime $timestamp;
    private string $subject;
    private string $description;
    private string $status;
    public const STATUS_PENDING = "PENDING";
    public const STATUS_EXECUTED = "EXECUTED";
    public const STATUS_REJECTED = "REJECTED";

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["report_id"];
            $this->user = new User();
            $this->user->setId($r["user_id"]);
            $this->user->setUsername($r["username"]);
            $this->user->setAttemptLeft($r["attempt_left"]);
            $this->user->setName($r["user_name"]);
            $this->user->setEmail($r["user_email"]);

            if ($r["post_id"] !== null) {
                $this->post = new Post();
                $this->post->setId($r["post_id"]);
                $this->post->setTitle($r["post_title"]);
                $this->post->setDate(date_create($r["post_date"]));
                $this->post->setType($r["post_type"]);
                $this->post->setCategory($r["post_category"]);
                $this->post->setContent($r["post_content"]);
            }

            if ($r["comment_id"] !== null) {
                $this->comment = new Comment();
                $this->comment->setId($r["comment_id"]);
                $this->comment->setContent($r["comment_content"]);
                $this->comment->setTimestamp($r["comment_timestamp"]);
            }

            $this->timestamp = date_create($r["report_timestamp"]);
            $this->subject = $r["subject"];
            $this->description = $r["description"];
            $this->status = $r["status"];
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

    public function hasPost(): bool {
        return isset($this->post);
    }

    public function getPost(): Post {
        return $this->post;
    }

    public function setPost(Post $post): void {
        $this->post = $post;
    }

    public function hasComment(): bool {
        return isset($this->comment);
    }

    public function getComment(): Comment {
        return $this->comment;
    }

    public function setComment(Comment $comment): void {
        $this->comment = $comment;
    }

    public function getTimestamp(): DateTime {
        return $this->timestamp;
    }

    public function setTimestamp(DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }

    public function getSubject(): string {
        return $this->subject;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}

?>