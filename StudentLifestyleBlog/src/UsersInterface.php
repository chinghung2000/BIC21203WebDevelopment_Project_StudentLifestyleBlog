<?php

declare(strict_types=1);

interface UsersInterface {
    public function getAllRecentPosts(int $count): array;
    public function getAllPopularPosts(int $count): array;
    public function getAnyPost(int $postId): Post|null;

    public function getLikesCount(int $postId): int;

    public function getAllCommentsByPostId(int $postId): array;

    public function addLogEntry(string $operation, string $description): bool;
}

?>