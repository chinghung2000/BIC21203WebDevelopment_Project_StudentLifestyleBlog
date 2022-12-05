<?php
    if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $uri = "https://";
    } else {
        $uri = "http://";
    }

    $uri .= $_SERVER["HTTP_HOST"];
    header("Location: " . $uri . "/blog");
    exit;
?>