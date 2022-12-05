<?php

declare(strict_types=1);
require_once "User.php";

// $admin = (new Admin())->login(1, "1234");
// if ($admin) echo $admin->getId();

$user = (new User())->login("asd", "asd");
if ($user) echo $user->getId();

?>