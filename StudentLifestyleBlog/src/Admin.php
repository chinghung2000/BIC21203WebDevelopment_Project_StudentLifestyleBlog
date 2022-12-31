<?php

declare(strict_types=1);
require_once "Users.php";
require_once "AdminInterface.php";
require_once "MySQL.php";
require_once "Comment.php";
require_once "Hash.php";
require_once "Log.php";
require_once "Report.php";
require_once "User.php";

class Admin extends Users implements AdminInterface {
    private int $id;
    private string $name;

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["admin_id"];
            $this->name = $r["admin_name"];
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function login(int $adminId, string $password): Admin|false {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `admin_id`, `admin_name` FROM `admin` WHERE `admin_id`=? AND `password`=?;");
                $password = Hash::generateDigest($password, Hash::SHA_256);
                $stmt->bind_param("is", $adminId, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Admin($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function updatePassword(int $adminId, string $password): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `admin` SET `password`=? WHERE `admin_id`=?;");
                $password = Hash::generateDigest($password, Hash::SHA_256);
                $stmt->bind_param("is", $password, $adminId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getAllAdmins(): array {
        $admins = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `admin_id`, `admin_name` FROM `admin`;");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($admins, new Admin($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $admins;
    }

    public function getAdmin(int $adminId): Admin|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `admin_id`, `admin_name` FROM `admin` WHERE `admin_id`=?;");
                $stmt->bind_param("i", $adminId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Admin($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function addAdmin(int $adminId, string $password, string $adminName): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `admin` (`admin_id`, `password`, `admin_name`) VALUES (?, ?, ?);");
                $password = Hash::generateDigest($password, Hash::SHA_256);
                $stmt->bind_param("iss", $adminId, $password, $adminName);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function updateAdmin(int $oldAdminId, int $adminId, string $adminName): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `admin` SET `admin_id`=?, `admin_name`=? WHERE `admin_id`=?;");
                $stmt->bind_param("isi", $adminId, $adminName, $oldAdminId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function deleteAdmin(int $adminId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `admin` WHERE `admin_id`=?;");
                $stmt->bind_param("i", $adminId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getAllLockedAccount(): array {
        $accounts = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `user_id`, `username`, `attempt_left`, `user_name`, `user_email` FROM `user` WHERE `attempt_left`=0;");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($accounts, new User($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $accounts;
    }

    public function updateRemainingAttempts(int $userId, int $attempt_left): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `user` SET `attempt_left`=? WHERE `user_id`=?;");
                $stmt->bind_param("ii", $attempt_left, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function deletePost(int $postId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `post` WHERE `post_id`=?;");
                $stmt->bind_param("i", $postId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getComment(int $commentId): Comment|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `c`.`comment_id`, `p`.`post_id`, `p`.`post_title`, `p`.`post_date`, `p`.`post_type`, `p`.`post_category`, `p`.`post_content`, `u`.`user_id`, `u`.`username`, `u`.`attempt_left`, `u`.`user_name`, `u`.`user_email`, `c`.`comment_content`, `c`.`comment_timestamp` FROM `comment` `c` INNER JOIN `post` `p` ON `c`.`post_id`=`p`.`post_id` INNER JOIN `user` `u` ON `c`.`user_id`=`u`.`user_id` WHERE `c`.`comment_id`=?;");
                $stmt->bind_param("i", $commentId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Comment($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function deleteComment(int $commentId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `comment` WHERE `comment_id`=?;");
                $stmt->bind_param("i", $commentId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getAllReports(): array {
        $reports = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `r`.`report_id`, `u`.`user_id`, `u`.`username`, `u`.`attempt_left`, `u`.`user_name`, `u`.`user_email`, `p`.`post_id`, `p`.`post_title`, `p`.`post_date`, `p`.`post_type`, `p`.`post_category`, `p`.`post_content`, `c`.`comment_id`, `c`.`comment_content`, `c`.`comment_timestamp`, `r`.`report_timestamp`, `r`.`subject`, `r`.`description`, `r`.`status` FROM `report` `r` INNER JOIN `user` `u` ON `r`.`user_id`=`u`.`user_id` LEFT JOIN `post` `p` ON `r`.`post_id`=`p`.`post_id` LEFT JOIN `comment` `c` ON `r`.`comment_id`=`c`.`comment_id`;");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($reports, new Report($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $reports;
    }

    public function getReport(int $reportId): Report|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `r`.`report_id`, `u`.`user_id`, `u`.`username`, `u`.`attempt_left`, `u`.`user_name`, `u`.`user_email`, `p`.`post_id`, `p`.`post_title`, `p`.`post_date`, `p`.`post_type`, `p`.`post_category`, `p`.`post_content`, `c`.`comment_id`, `c`.`comment_content`, `c`.`comment_timestamp`, `r`.`report_timestamp`, `r`.`subject`, `r`.`description`, `r`.`status` FROM `report` `r` INNER JOIN `user` `u` ON `r`.`user_id`=`u`.`user_id` INNER JOIN `post` `p` ON `r`.`post_id`=`p`.`post_id` INNER JOIN `comment` `c` ON `r`.`comment_id`=`c`.`comment_id` WHERE `r`.`report_id`=?;");
                $stmt->bind_param("i", $reportId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Report($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function updateReportStatus(int $reportId, string $status): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `report` SET `status`=? WHERE `report_id`=?;");
                $stmt->bind_param("si", $status, $reportId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getAllLogs(): array {
        $logs = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `log_id`, `operation`, `description` FROM `log` ORDER BY `log_id` DESC;");
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($logs, new Log($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $logs;
    }

    public function getLogsByOperation(string $operation): array {
        $logs = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `log_id`, `operation`, `description` FROM `log` WHERE `operation`=? ORDER BY `log_id` DESC;");
                $stmt->bind_param("s", $operation);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($logs, new Log($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $logs;
    }
}

?>