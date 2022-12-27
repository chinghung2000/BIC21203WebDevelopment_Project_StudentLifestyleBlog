<?php

declare(strict_types=1);
include_once "constants.php";

$userId = $_SESSION["user_id"];
$userType = $_SESSION["user_type"];

if ($userId == null || $userType == null || $userType != "admin") {
    header("Location: " . WEBSITE_PATH . "/");
} else {
    if ($_SERVER["PHP_SELF"] == WEBSITE_PATH . "/checkSessionAdmin.php") {
        header("Location: " . WEBSITE_PATH . "/");
    }
}

?>