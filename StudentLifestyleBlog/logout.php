<?php

declare(strict_types=1);
include_once "constants.php";

session_start();

$userType = array_key_exists("user_type", $_SESSION) ? $_SESSION["user_type"] : null;

session_unset();
session_destroy();

if ($userType == "admin") {
    header("Location: " . WEBSITE_PATH . "/admin");
} else if ($userType == "user") {
    header("Location: " . WEBSITE_PATH);
} else {
    header("Location: " . WEBSITE_PATH);
}

?>