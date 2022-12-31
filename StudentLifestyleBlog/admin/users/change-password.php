<?php

declare(strict_types=1);
require_once "../../src/Admin.php";
require_once "../../src/Log.php";
include_once "../../functions.php";
include_once "../../checkSessionAdmin.php";

$U_admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!array_key_exists("password", $_POST)) {
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
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];

        $ok = $U_admin->updatePassword(intval($S_userId), $password);

        if ($ok) {
            $U_admin->addLogEntry(Log::OPERATION_UPDATE_PASSWORD, "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $S_userId
                . " updated the password");
            header("Location: " . WEBSITE_PATH . "/admin/login.php");
        } else {
            echo JSAlert("Error 500: Internal Server Error\n\nCouldn\'t update password.");
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

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../css/admin.css">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../css/style.css">

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
                    <?php echo htmlspecialchars($currAdmin->getName()); ?> (ID: <?php echo htmlspecialchars(strval($currAdmin->getId())); ?>)
                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
                </a>
                <ul>
                    <li><a href="./">&lt;&lt;&lt; Back</a></li>
                    <li><a href="../../logout.php" class="logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </header>


    <!--log in-->

    <div class="auth-content">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="form-title">Change Password</h2>

            <div>
                <label>Password</label>
                <input type="password" name="password" class="text-input">
            </div>

            <div>
                <label>Confirm Password</label>
                <input type="password" name="cpassword" class="text-input">
            </div>

            <div>
                <button type="submit" name="login-btn" class="btn btn-big">Submit</button>
            </div>

        </form>
    </div>


    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Custom Script -->
    <script src="js/scripts.js"></script>

</body>

</html>