<?php

declare(strict_types=1);

$db = new mysqli("localhost", "appuser", "1234", "blogsys");
$id = 1;
$stmt = $db->prepare("SELECT * FROM `post`;");
// $stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $date = date_create($row["post_date"]);
    echo date_format($date, "F j, Y");
}

?>