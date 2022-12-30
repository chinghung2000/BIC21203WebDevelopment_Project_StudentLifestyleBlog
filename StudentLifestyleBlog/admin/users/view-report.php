<?php

declare(strict_types=1);
require_once "../../src/Admin.php";
require_once "../../src/Log.php";
require_once "../../src/Report.php";
include_once "../../functions.php";
include_once "../../checkSessionAdmin.php";

$U_admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["method"])) {
        if ($_POST["method"] == "execute") {
            if (!empty($_POST["report_id"]) && !empty($_POST["target_type"]) && !empty($_POST["target_id"])) {
                $reportId = $_POST["report_id"];
                $targetType = $_POST["target_type"];
                $targetId = $_POST["target_id"];

                if ($targetType == "post") {
                    $post = $U_admin->getAnyPost(intval($targetId));

                    if ($post) {
                        $U_admin->deletePost($post->getId());
                        $U_admin->updateReportStatus(intval($reportId), Report::STATUS_EXECUTED);
                        $U_admin->addLogEntry(Log::OPERATION_DELETE, "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $S_userId
                            . " deleted post (ID: \"" . $post->getId() . "\", Title: \"" . $post->getTitle() . "\")");
                    }
                } else if ($targetType == "comment") {
                    $comment = $U_admin->getComment(intval($targetId));

                    if ($comment) {
                        $U_admin->deleteComment(intval($targetId));
                        $U_admin->updateReportStatus(intval($reportId), Report::STATUS_EXECUTED);
                        $U_admin->addLogEntry(Log::OPERATION_DELETE, "[" . date_format(new DateTime(), "d/m/Y h:i:s A") . "] Admin " . $S_userId
                            . " deleted comment (ID: \"" . $comment->getId() . "\")");
                    }
                }
            }
        } else if ($_POST["method"] == "reject") {
            if (!empty($_POST["report_id"])) {
                $reportId = $_POST["report_id"];

                $U_admin->updateReportStatus(intval($reportId), Report::STATUS_REJECTED);
            }
        }
    }
}

$currAdmin = $U_admin->getAdmin(intval($S_userId));
$reports = $U_admin->getAllReports();

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

    <title>View Report</title>

    <script type="text/JavaScript">
        function executeCall($reportId, $targetType, $targetId) {
            $form = document.getElementById("execute-call-form");
            $form.elements["report_id"].value = $reportId;
            $form.elements["target_type"].value = $targetType;
            $form.elements["target_id"].value = $targetId;
            $form.submit();
        }

        function rejectCall($reportId) {
            $form = document.getElementById("reject-call-form");
            $form.elements["report_id"].value = $reportId;
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
                    <?php echo htmlspecialchars($currAdmin->getName()); ?> (ID: <?php echo htmlspecialchars(strval($currAdmin->getId())); ?>)
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
                <li><a href="./">Manage Admin</a></li>
                <li><a href="../log-activity">Log Activity</a></li>
                <li><a href="#">View Report</a></li>
                <li><a href="../../logout.php" class="logout">Logout</a></li>
            </ul>
        </div>

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
            </div>


            <div class="content">

                <h2 class="page-title">View Report</h2>

                <table>
                    <thead>
                        <th>ID</th>
                        <th>Initiator</th>
                        <th>Post /<br>Comment</th>
                        <th>Author /<br>Commenter</th>
                        <th>Reason</th>
                        <th>Timestamp</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <form id="execute-call-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="method" value="execute">
                            <input type="hidden" name="report_id" value="">
                            <input type="hidden" name="target_type" value="">
                            <input type="hidden" name="target_id" value="">
                        </form>
                        <form id="reject-call-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="method" value="reject">
                            <input type="hidden" name="report_id" value="">
                        </form>
                        <?php foreach ($reports as $report) :
                            if ($report->hasPost()) {
                                $type = "post";
                                $target = $U_admin->getAnyPost(intval($report->getPost()->getId()));
                            } else if ($report->hasComment()) {
                                $type = "comment";
                                $target = $U_admin->getComment(intval($report->getComment()->getId()));
                            } else {
                                $type = "";
                            } ?>
                            <tr>
                                <td><?php echo htmlspecialchars(strval($report->getId())); ?></td>
                                <td><?php echo htmlspecialchars($report->getUser()->getName()); ?> (ID: <?php echo htmlspecialchars(strval($report->getUser()->getId())); ?>)</td>
                                <td>
                                    <a href="#"><b><?php echo htmlspecialchars($type == "post" ? $target->getTitle() : ($type == "comment" ? $target->getContent() : "")); ?></b></a>
                                </td>
                                <td>
                                    <?php if ($type) : ?>
                                        <?php echo htmlspecialchars($target->getUser()->getName()); ?> (ID: <?php echo htmlspecialchars(strval($target->getUser()->getId())); ?>)
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <b><?php echo htmlspecialchars($report->getSubject()); ?></b>
                                    <br>
                                    <?php echo htmlspecialchars($report->getDescription()); ?>
                                </td>
                                <td><?php echo htmlspecialchars(date_format($report->getTimestamp(), "d/m/Y h:i:s A")); ?></td>
                                <td><?php echo htmlspecialchars($report->getStatus()); ?></td>
                                <td>
                                    <?php if ($type && $report->getStatus() == "PENDING") : ?>
                                        <a href="#" class="edit" onclick="executeCall('<?php echo htmlspecialchars(strval($report->getId())); ?>', '<?php echo htmlspecialchars($type); ?>', '<?php echo htmlspecialchars(strval($target->getId())); ?>');">Execute</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($type && $report->getStatus() == "PENDING") : ?>
                                        <a href="#" class="delete" onclick="rejectCall('<?php echo htmlspecialchars(strval($report->getId())); ?>');">Reject</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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