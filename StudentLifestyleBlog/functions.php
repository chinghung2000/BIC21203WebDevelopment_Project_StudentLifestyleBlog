<?php

declare(strict_types=1);

function JSAlert(string $message): string {
    return "<script type='text/JavaScript'>alert('" . $message . "');</script>";
}

function sanitize(string $string): string {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

?>