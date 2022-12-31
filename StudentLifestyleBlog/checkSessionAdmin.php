<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$S_userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
$S_userType = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;

if ($S_userId == null || $S_userType == null || $S_userType != "admin") {
    header("Location: " . WEBSITE_PATH . "/admin");
} else {
    if ($_SERVER["PHP_SELF"] == WEBSITE_PATH . "/checkSessionAdmin.php") {
        header("Location: " . WEBSITE_PATH);
    }
}

?>