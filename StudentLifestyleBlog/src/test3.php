<?php

declare(strict_types=1);
require_once "MySQL.php";
require_once "Post.php";

if ($db = (new MySQL())->connect()) {
    try {
        $stmt = $db->prepare("SELECT `p`.`post_id`, `p`.`post_title`, `p`.`post_date`, `p`.`post_type`, `p`.`post_category`, `p`.`post_content`, `u`.`user_id`, `u`.`username`, `u`.`attempt_left`, `u`.`user_name`, `u`.`user_email` FROM `post` `p` INNER JOIN `user` `u` ON `p`.`user_id`=`u`.`user_id`;");
        echo $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        echo $e;
    }
}
// $result = $stmt->get_result();

// if ($r = $result->fetch_assoc()) {
//     $post = new Post($r);
//     echo $post->getUser()->getName();
// }

?>