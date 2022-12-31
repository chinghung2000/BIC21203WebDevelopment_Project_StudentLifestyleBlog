<?php

declare(strict_types=1);
require_once "../../src/Admin.php";
include_once "../../functions.php";
include_once "../../checkSessionAdmin.php";

$U_admin = new Admin();
$operation = "";
$logs = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!array_key_exists("operation", $_GET)) {
        $logs = $U_admin->getAllLogs();
    } else {
        $operation = $_GET["operation"];
        $allowedOperations = ["REGISTER", "FAILED_LOGIN", "UPDATE_PASSWORD", "INSERT", "UPDATE", "DELETE"];

        if (in_array(strtoupper($operation), $allowedOperations)) {
            $logs = $U_admin->getLogsByOperation($operation);
        } else {
            $operation = "";
            $logs = $U_admin->getAllLogs();
        }
    }
}

$currAdmin = $U_admin->getAdmin(intval($S_userId));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../css/style.css">

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../css/admin.css">

    <title>Dashboard</title>
</head>

<body>
    <header>
        <div class="logo">
            <h1 class="logo-text"><span>StudentHabitsBlog</h1>
        </div>
        <i class="fa fa-bars menu-toggle"></i>
        <ul class="nav">
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <?php echo htmlspecialchars($currAdmin->getName()); ?> (ID: <?php echo htmlspecialchars(strval($currAdmin->getId())); ?>)
                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                </a>
                <ul>
                    <li><a href="../users/change-password.php">Change Password</a></li>
                    <li><a href="../../logout.php" class="logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </header>

    <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">

        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <ul>
                <li><a href="../users">Manage Admin</a></li>
                <li><a href="#">Log Activity</a></li>
                <li><a href="../users/view-report.php">View Report</a></li>
                <li><a href="../../logout.php" class="logout">Logout</a></li>
            </ul>
        </div>


        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">

                <h2 class="page-title">Log Activity (<?php echo ($operation != "") ? $operation : "ALL"; ?>)</h2>

                <div class="dropdown">
                    <button class="dropbtn">Choose Operation:</button>
                    <div class="dropdown-content">
                        <a href="?">ALL OPERATION</a>
                        <a href="?operation=REGISTER">REGISTER</a>
                        <a href="?operation=FAILED_LOGIN">FAILED_LOGIN</a>
                        <a href="?operation=UPDATE_PASSWORD">UPDATE_PASSWORD</a>
                        <a href="?operation=INSERT">INSERT</a>
                        <a href="?operation=UPDATE">UPDATE</a>
                        <a href="?operation=DELETE">DELETE</a>
                    </div>
                </div>
                <br><br>
                <table>
                    <thead>
                        <th>No</th>
                        <th>Description</th>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($logs as $log) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($log->getDescription()); ?></td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>

            </div>
            </tbody>
            </table>
        </div>
    </div>
    </div>


    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Custom Script -->
    <script src="../../js/scripts.js"></script>

</body>

</html>