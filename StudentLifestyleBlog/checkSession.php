<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$S_userId = array_key_exists("user_id", $_SESSION) ? $_SESSION["user_id"] : null;
$S_userType = array_key_exists("user_type", $_SESSION) ? $_SESSION["user_type"] : null;

if ($S_userId != null && $S_userType != null) {
    if ($S_userType == "admin") {
        header("Location: " . WEBSITE_PATH . "/admin/users");
    } else if ($S_userType == "user") {
        header("Location: " . WEBSITE_PATH);
    }
} else {
    if ($_SERVER["PHP_SELF"] == WEBSITE_PATH . "/checkSession.php") {
        header("Location: " . WEBSITE_PATH);
    }
}

?>