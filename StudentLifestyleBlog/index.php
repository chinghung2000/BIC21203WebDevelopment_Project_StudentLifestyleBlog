<?php

session_start();
echo "Session ID: " . session_id();
echo "<br>";
echo "\$_SESSION[\"user_id\"] = " . (isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "(None)");
echo "<br>";
echo "\$_SESSION[\"user_type\"] = " . (isset($_SESSION["user_type"]) ? $_SESSION["user_type"] : "(None)");

?>