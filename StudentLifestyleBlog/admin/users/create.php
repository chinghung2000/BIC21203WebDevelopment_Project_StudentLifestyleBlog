<?php

declare(strict_types=1);
require_once "../../src/Admin.php";
require_once "../../src/Log.php";
include_once "../../functions.php";
include_once "../../checkSessionAdmin.php";

$U_admin = new Admin();
$adminId = $adminName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = array_key_exists("admin_id", $_POST) ? $_POST["admin_id"] : "";
    $adminName = array_key_exists("admin_name", $_POST) ? $_POST["admin_name"] : "";
    $password = array_key_exists("password", $_POST) ? $_POST["password"] : "";
    $cpassword = array_key_exists("cpassword", $_POST) ? $_POST["cpassword"] : "";

    if (!array_key_exists("admin_id", $_POST)) {
        echo JSAlert("Error 400: Bad Request: Parameter 'admin_id' is required");
    } else if ($_POST["admin_id"] == "") {
        echo JSAlert("Please enter admin ID.");
    } else if (!is_numeric(($_POST["admin_id"]))) {
        echo JSAlert("Admin ID must be an integer.");
    } else if (intval($_POST["admin_id"]) < 1) {
        echo JSAlert("Admin ID must be greater than zero.");
    } else if (intval($_POST["admin_id"]) > 2147483647) {
        echo JSAlert("Admin ID must not exceed 2147483647.");
    } else if (!array_key_exists("admin_name", $_POST)) {
        echo JSAlert("Error 400: Bad Request: Parameter 'admin_name' is required");
    } else if ($_POST["admin_name"] == "") {
        echo JSAlert("Please enter admin name.");
    } else if (strlen($_POST["admin_name"]) > 50) {
        echo JSAlert("Admin name must not exceed 50 characters long.");
    } else if (!array_key_exists("password", $_POST)) {
        echo JSAlert("Error 400: Bad Request: Parameter 'password' is required");
    } else if ($_POST["password"] == "") {
        echo JSAlert("Please enter password.");
    } else if (strlen($_POST["password"]) < 8) {
        echo JSAlert("Password can\'t be less than 8 characters long.");
    } else if (strlen($_POST["password"]) > 16) {
        echo JSAlert("Password must not exceed 16 characters long.");
    } else if (!array_key_exists("cpassword", $_POST)) {
        echo JSAlert("Error 400: Bad Request: Parameter 'cpassword' is required");
    } else if ($_POST["cpassword"] == "") {
        echo JSAlert("Please confirm the password.");
    } else if ($_POST["password"] != $_POST["cpassword"]) {
        echo JSAlert("Password didn\'t match.");
    } else {
        $admin = $U_admin->getAdmin(intval($adminId));

        if (!$admin) {
            $ok = $U_admin->addAdmin(intval($adminId), $password, $adminName);

            if ($ok) {
                $U_admin->addLogEntry(Log::OPERATION_INSERT, "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $S_userId
                    . " added new admin (ID: \"" . $adminId . "\", Name: \"" . $adminName . "\")");
                header("Location: " . WEBSITE_PATH . "/admin/users");
            } else {
                echo JSAlert("Error 500: Internal Server Error\n\nCouldn\'t add admin.");
            }
        } else {
            echo JSAlert("Admin with this ID \"" . $admin->getId() . "\" already exists.");
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

    <title>Add Admin</title>
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
                    <li><a href="change-password.php">Change Password</a></li>
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
                <li><a href="./">Manage Admin</a></li>
                <li><a href="../log-activity">Log Activity</a></li>
                <li><a href="view-report.php">View Report</a></li>
                <li><a href="../../logout.php" class="logout">Logout</a></li>
            </ul>
        </div>


        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
            </div>


            <div class="content">

                <h2 class="page-title">Add Admin</h2>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label>Admin ID</label>
                        <input type="text" name="admin_id" class="text-input" value="<?php echo htmlspecialchars($adminId); ?>">
                    </div>
                    <div>
                        <label>Name</label>
                        <input type="text" name="admin_name" class="text-input" value="<?php echo htmlspecialchars($adminName); ?>">
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" class="text-input">
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" class="text-input">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-big">Add Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
    <!-- Custom Script -->
    <script src="../../js/scripts.js"></script>

</body>

</html>