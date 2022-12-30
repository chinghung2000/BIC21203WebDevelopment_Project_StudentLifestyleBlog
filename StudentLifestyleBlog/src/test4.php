<?php

declare(strict_types=1);
require_once "AES.php";

$string = "admin";
$cipher = AES::encrypt($string);
echo $cipher;
echo "<br>";
echo AES::decrypt($cipher);

?>