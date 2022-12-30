<?php

declare(strict_types=1);

interface AdminInterface {
    public function login(int $adminId, string $password): Admin|false;
    public function updatePassword(int $adminId, string $password): bool;

    public function getAllAdmins(): array;
    public function getAdmin(int $adminId): Admin|null;
    public function addAdmin(int $adminId, string $password, string $adminName): bool;
    public function updateAdmin(int $oldAdminId, int $adminId, string $adminName): bool;
    public function deleteAdmin(int $adminId): bool;

    public function getAllLockedAccount(): array;
    public function updateRemainingAttempts(int $userId, int $attempt_left): bool;

    public function deletePost(int $postId): bool;

    public function getComment(int $commentId): Comment|null;
    public function deleteComment(int $commentId): bool;

    public function getAllReports(): array;
    public function getReport(int $reportId): Report|null;
    public function updateReportStatus(int $reportId, string $status): bool;

    public function getAllLogs(): array;
    public function getLogsByOperation(string $operation): array;
}

?>