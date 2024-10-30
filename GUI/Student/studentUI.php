<?php
require_once '../../BLL/studentBLL.php';

navigateIfNeed('student');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["currentTab"])) {
        $_SESSION["currentTab"] = $_POST["currentTab"];
    } else {
        logout();
    }
}
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="studentUI.css">
</head>
<body>
    <!--Left side bar-->
    <div class="sidebar">
        <div class="logo-content">
            <div class="logo">
                <i class='bx bxs-invader'></i>
                <h3>Sinh viên</h3>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>

        <ul class="list">
            <form action="" method="post">
                <li <?php
                if ($_SESSION["currentTab"] != "dashboardTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Dashboard" onClick="openTab('dashboardTab');">
                        <i class='bx bxs-dashboard'></i>
                        <span class="links-name">Dashboard</span>
                    </a>
                </li>

                <li <?php
                if ($_SESSION["currentTab"] != "scoreTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Class" onClick="openTab('scoreTab');">
                        <i class='bx bx-door-open'></i>
                        <span class="links-name">Kết quả học tập</span>
                    </a>
                </li>
            </form>
        </ul>

        <form action="" method="post" id="logoutForm">
            <ul class="list-logout">
                <li>
                    <a href="#" onClick="login();">
                        <i class='bx bx-log-out'></i>
                        <span class="links-name">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </form>
    </div>

    <!--Content-->
    <div class="content">
        <!--Navigation bar-->
        <?php include "nav.php"; ?>

        <!--TAB-->
        <div id="dashboardTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "dashboardTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Student/Tab/dashboardTabUI.php";
            ?>
        </div>

        <div id="scoreTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "scoreTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Student/Tab/scoreTabUI.php";
            ?>
        </div>
    </div>
    <script src="studentUI.js"></script>
</body>
</html>