<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$S_userId = array_key_exists("user_id", $_SESSION) ? $_SESSION["user_id"] : null;
$S_userType = array_key_exists("user_type", $_SESSION) ? $_SESSION["user_type"] : null;
$S_lastCreated = array_key_exists("last_created", $_SESSION) ? $_SESSION["last_created"] : 0;

if (time() - $S_lastCreated > 1800) {
    header("Location: " . WEBSITE_PATH . "/logout.php");
} else if ($S_userId == null || $S_userType == null || $S_userType != "user") {
    header("Location: " . WEBSITE_PATH);
} else {
    $_SESSION["last_created"] = time();

    if ($_SERVER["PHP_SELF"] == WEBSITE_PATH . "/checkSessionUser.php") {
        header("Location: " . WEBSITE_PATH);
    }
}

?>