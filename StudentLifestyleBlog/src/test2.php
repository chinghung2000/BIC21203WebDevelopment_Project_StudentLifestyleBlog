<?php

declare(strict_types=1);
require_once "Admin.php";
require_once "User.php";

$admin = (new Admin())->login(1, "admin");
if ($admin) echo $admin->getName();

// $user = (new User())->login("asd", "asd");
// if ($user) echo $user->getId();

?>