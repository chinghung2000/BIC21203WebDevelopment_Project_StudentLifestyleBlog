<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$userType = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;

if ($userId != null && $userType != null) {
    if ($userType == "admin") {
        header("Location: " . WEBSITE_PATH . "/admin/users");
    } else if ($userType == "user") {
        header("Location: " . WEBSITE_PATH);
    }
} else {
    if ($_SERVER["PHP_SELF"] == WEBSITE_PATH . "/checkSession.php") {
        header("Location: " . WEBSITE_PATH);
    }
}

?>