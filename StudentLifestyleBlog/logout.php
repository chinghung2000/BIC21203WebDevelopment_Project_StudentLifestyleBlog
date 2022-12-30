<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$userType = isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : null;

session_unset();
session_destroy();

if ($userType != null) {
    if ($userType == "admin") {
        header("Location: " . WEBSITE_PATH . "/admin");
    } else if ($userType == "user") {
        header("Location: " . WEBSITE_PATH);
    }
}

?>