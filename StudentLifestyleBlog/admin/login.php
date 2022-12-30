<?php

declare(strict_types=1);
require_once "../src/Admin.php";
require_once "../src/Log.php";
include_once "../functions.php";
include_once "../checkSession.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["admin_id"])) {
        echo JSAlert("Please enter admin ID.");
    } else if (strlen($_POST["admin_id"]) > 16) {
        echo JSAlert("Admin ID too long.");
    } else if (empty($_POST["password"])) {
        echo JSAlert("Please enter password.");
    } else if (strlen($_POST["password"]) > 16) {
        echo JSAlert("Password too long.");
    } else {
        $adminId = $_POST["admin_id"];
        $password = $_POST["password"];

        $publicUser = new Admin();
        $U_admin = $publicUser->login(intval($adminId), $password);

        if ($U_admin) {
            $_SESSION["user_id"] = $U_admin->getId();
            $_SESSION["user_type"] = "admin";
            header("Location: " . WEBSITE_PATH . "/admin/login.php");
        } else {
            $publicUser->addLogEntry(Log::OPERATION_FAILED_LOGIN, "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $adminId
                . " attempted to log in with incorrect credential");
            echo JSAlert("Incorrect username or password.");
        }
    }
}

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

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../admin/../css/admin.css">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Admin Login</title>
</head>

<body>
    <header>
        <div class="logo">
            <h1 class="logo-text"><span>StudentHabitsBlog</h1>
        </div>
        <i class="fa fa-bars menu-toggle"></i>
        <ul class="nav">

            <!-- <li><a href="#">Sign Up</a></li>
      <li><a href="#">Login</a></li> -->
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>

                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                </a>
                <ul>
                    <!-- <li><a href="#">Dashboard</a></li>
                    <li><a href="#" class="logout">Logout</a></li> -->
                </ul>
            </li>
        </ul>
    </header>


    <!--log in-->

    <div class="auth-content">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="form-title">Admin Login</h2>

            <div>
                <label>Admin ID</label>
                <input type="text" name="admin_id" class="text-input">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" class="text-input">
            </div>

            <div>
                <button type="submit" name="login-btn" class="btn btn-big">Login</button>
            </div>

        </form>
    </div>


    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Custom Script -->
    <script src="js/scripts.js"></script>

</body>

</html>