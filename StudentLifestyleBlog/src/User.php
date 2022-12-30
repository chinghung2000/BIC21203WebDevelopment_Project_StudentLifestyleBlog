<?php

declare(strict_types=1);
require_once "Users.php";
require_once "UserInterface.php";
require_once "MySQL.php";

class User extends Users implements UserInterface {
    private int $id;
    private string $username;
    private int $attemptLeft;
    private string $name;
    private string $email;

    function __construct(array $r = null) {
        if ($r) {
            $this->id = $r["user_id"];
            $this->username = $r["username"];
            $this->attemptLeft = $r["attempt_left"];
            $this->name = $r["user_name"];
            $this->email = $r["user_email"];
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getAttemptLeft(): int {
        return $this->attemptLeft;
    }

    public function setAttemptLeft(int $attemptLeft): void {
        $this->attemptLeft = $attemptLeft;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function login(string $username, string $password): User|false {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `user_id`, `username`, `attempt_left`, `user_name`, `user_email` FROM `user` WHERE `username`=? AND `password`=?;");
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new User($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getUser(int $userId): User {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `user_id`, `username`, `attempt_left`, `user_name`, `user_email` FROM `user` WHERE `user_id`=?;");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new User($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function addUser(string $username, string $userName, string $userEmail): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `user` (`username`, `user_name`, `user_email`) VALUES (?, ?, ?);");
                $stmt->bind_param("sss", $username, $userName, $userEmail);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function updateUser(int $userId, string $username, string $userName, string $userEmail): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `user` SET `username`=?, `user_name`=?, `user_email`=? WHERE `user_id`=?;");
                $stmt->bind_param("sssi", $username, $userName, $userEmail, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function updatePassword(int $userId, string $password): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `user` SET `password`=? WHERE `user_id`=?;");
                $stmt->bind_param("si", $password, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function checkUsername(string $username): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `username` FROM `user` WHERE `username`=?;");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return true;
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getPost(int $postId, int $userId): Post|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `post_id`, `user_id`, `post_title`, `post_date`, `post_type`, `post_category`, `post_content` FROM `post` WHERE `post_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $postId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Post($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function addPost(int $userId, string $title, string $type, string $category, string $content): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `post` (`user_id`, `post_title`, `post_type`, `post_category`, `post_content`) VALUES (?, ?, ?, ?, ?);");
                $stmt->bind_param("issss", $userId, $title, $type, $category, $content);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function updatePost(int $postId, int $userId, string $title, string $type, string $category, string $content): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("UPDATE `post` SET `post_title`=?, `post_type`=?, `post_category`=?, `post_content`=? WHERE `post_id`=? AND `user_id`=?;");
                $stmt->bind_param("ssssii", $title, $type, $category, $content, $postId, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function deletePost(int $postId, int $userId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `post` WHERE `post_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $postId, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getLike(int $likeId, int $userId): Like|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `like_id`, `post_id`, `user_id`, `like_timestamp` FROM `likes` WHERE `like_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $likeId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return new Like($r);
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function addLike(int $postId, int $userId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `likes` (`post_id`, `user_id`) VALUES (?, ?);");
                $stmt->bind_param("ii", $postId, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function deleteLike(int $likeId, int $userId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `likes` WHERE `like_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $likeId, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function getComment(int $commentId, int $userId): Comment|null {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `comment_id`, `post_id`, `user_id`, `comment_content`, `comment_timestamp` FROM `comment` WHERE `comment_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $commentId, $userId);
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

    public function addComment(int $postId, int $userId, string $content): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `comment` (`post_id`, `user_id`, `comment_content`) VALUES (?, ?, ?);");
                $stmt->bind_param("iis", $postId, $userId, $content);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function deleteComment(int $commentId, int $userId): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("DELETE FROM `comment` WHERE `comment_id`=? AND `user_id`=?;");
                $stmt->bind_param("ii", $commentId, $userId);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function addPostReport(int $userId, int $postId, string $subject, string $description): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `report` (`user_id`, `post_id`, `subject`, `description`) VALUES (?, ?, ?, ?);");
                $stmt->bind_param("iiss", $userId, $postId, $subject, $description);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }

    public function addCommentReport(int $userId, int $commentId, string $subject, string $description): bool {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("INSERT INTO `report` (`user_id`, `comment_id`, `subject`, `description`) VALUES (?, ?, ?, ?);");
                $stmt->bind_param("iiss", $userId, $commentId, $subject, $description);
                return $stmt->execute();
            } catch (mysqli_sql_exception $e) {
            }
        }

        return false;
    }
}
