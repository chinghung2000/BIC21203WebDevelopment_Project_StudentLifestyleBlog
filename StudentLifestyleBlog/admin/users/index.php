<?php

declare(strict_types=1);
require_once "../../src/Admin.php";
include_once "../../functions.php";
include_once "../../checkSessionAdmin.php";

$U_admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["method"])) {
        if ($_POST["method"] == "delete") {
            if (!empty($_POST["admin_id"])) {
                $adminId = $_POST["admin_id"];

                if ($adminId != $S_userId) {
                    $admin = $U_admin->getAdmin(intval($adminId));

                    if ($admin) {
                        $U_admin->deleteAdmin(intval($adminId));
                        $U_admin->addLogEntry("DELETE", "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $S_userId
                            . " deleted admin (ID: \"" . $admin->getId() . "\", Name: \"" . $admin->getName() . "\")");
                    } else {
                        echo JSAlert("The admin doesn't exist.");
                    }
                } else {
                    echo JSAlert("Currently logged in admin cannot be deleted.");
                }
            }
        }
    }
}

$currAdmin = $U_admin->getAdmin($S_userId);
$admins = $U_admin->getAllAdmins();

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

    <title>Manage Admin</title>

    <script type="text/JavaScript">
        function deleteCall($adminId) {
            $form = document.getElementById("delete-call-form");
            $form.elements["admin_id"].value = $adminId;
            $form.submit();
        }
    </script>
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
                    <?php echo htmlspecialchars($currAdmin->getName()); ?>
                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                </a>
                <ul>
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
                <li><a href="#">Manage Admin</a></li>
                <li><a href="../log-activity">Log Activity</a></li>
                <li><a href="view-report.php">View Report</a></li>
                <li><a href="../../logout.php" class="logout">Logout</a></li>
            </ul>
        </div>

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
                <a href="create.php" class="btn btn-big">Add Admin</a>
            </div>


            <div class="content">

                <h2 class="page-title">Manage Admin</h2>

                <table>
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <form id="delete-call-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="method" value="delete">
                            <input type="hidden" name="admin_id" value="">
                        </form>
                        <?php $i = 1;
                        foreach ($admins as $admin) : ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($admin->getName()); ?></td>
                                <td>Admin</td>
                                <td><a href="#" class="edit">Edit</a></td>
                                <td>
                                    <a href="#" class="delete" onclick="deleteCall('<?php echo htmlspecialchars(strval($admin->getId())); ?>');">Delete</a>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
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