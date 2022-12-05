<?php

declare(strict_types=1);

interface UserInterface {
    public function login(string $userName, string $password): User|false;
    public function getUser(int $userId): User|null;
    public function addUser(string $username, string $userName, string $userEmail): bool;
    public function updateUser(int $userId, string $username, string $userName, string $userEmail): bool;
    public function updatePassword(int $userId, string $password): bool;
    public function checkUsername(string $username): bool;

    public function getPost(int $postId, int $userId): Post|null;
    public function addPost(int $userId, string $title, string $type, string $category, string $content): bool;
    public function updatePost(int $postId, int $userId, string $title, string $type, string $category, string $content): bool;
    public function deletePost(int $postId, int $userId): bool;

    public function getLike(int $likeId, int $userId): Like|null;
    public function addLike(int $postId, int $userId): bool;
    public function deleteLike(int $likeId, int $userId): bool;

    public function getComment(int $commentId, int $userId): Comment|null;
    public function addComment(int $postId, int $userId, string $content): bool;
    public function deleteComment(int $commentId, int $userId): bool;

    public function addPostReport(int $userId, int $postId, string $subject, string $description): bool;
    public function addCommentReport(int $userId, int $commentId, string $subject, string $description): bool;
}

?>