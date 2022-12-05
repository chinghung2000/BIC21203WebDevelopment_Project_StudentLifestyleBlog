<?php

declare(strict_types=1);
require_once "MySQL.php";
require_once "UsersInterface.php";

class Users implements UsersInterface {
    public function getAllRecentPosts(int $count): array {
        $posts = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `post_id`, `user_id`, `post_title`, `post_date`, `post_type`, `post_category`, `post_content` FROM `post` ORDER BY `post_date` DESC LIMIT ?;");
                $stmt->bind_param("i", $count);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($posts, new Post($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $posts;
    }

    public function getAllPopularPosts(int $count): array {
        $posts = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `p`.`post_id`, `p`.`user_id`, `p`.`post_title`, `p`.`post_date`, `p`.`post_type`, `p`.`post_category`, `p`.`post_content`, COUNT(`l`.`like_id`) `likes_count` FROM `post` `p` LEFT JOIN `likes` `l` ON `p`.`post_id`=`l`.`post_id` GROUP BY `p`.`post_id` ORDER BY `likes_count` DESC LIMIT ?;");
                $stmt->bind_param("i", $count);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($posts, new Post($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $posts;
    }

    public function getAnyPost(int $postId): Post {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `post_id`, `user_id`, `post_title`, `post_date`, `post_type`, `post_category`, `post_content` FROM `post` WHERE `post_id`=?;");
                $stmt->bind_param("i", $postId);
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

    public function getLikesCount(int $postId): int {
        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT COUNT(`like_id`) `likes_count` FROM `likes` WHERE `post_id`=?;");
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($r = $result->fetch_assoc()) {
                    return $r["likes_count"];
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return null;
    }

    public function getAllCommentsByPostId(int $postId): array {
        $comments = [];

        if ($db = (new MySQL())->connect()) {
            try {
                $stmt = $db->prepare("SELECT `comment_id`, `post_id`, `user_id`, `comment_content`, `comment_timestamp` FROM `comment` WHERE `post_id`=?;");
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($r = $result->fetch_assoc()) {
                    array_push($comments, new Comment($r));
                }
            } catch (mysqli_sql_exception $e) {
            }
        }

        return $comments;
    }

    // if ($db = (new MySQL())->connect()) {
    //     try {
    //         $stmt = $db->prepare(";");
    //         $stmt->bind_param("",);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         if ($r = $result->fetch_assoc()) {

    //         }
    //     } catch (mysqli_sql_exception $e) {
    //     }
    // }

    // return null;
}

?>