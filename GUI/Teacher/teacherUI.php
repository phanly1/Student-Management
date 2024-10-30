<?php
require_once '../../BLL/teacherBLL.php';

navigateIfNeed('teacher');

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
    <title>Giảng viên</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="teacherUI.css">
</head>
<body>
    <!--Left side bar-->
    <div class="sidebar">
        <div class="logo-content">
            <div class="logo">
                <i class='bx bxs-invader'></i>
                <h3>Giảng viên</h3>
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
                if ($_SESSION["currentTab"] != "classTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Class" onClick="openTab('classTab');">
                        <i class='bx bx-door-open'></i>
                        <span class="links-name">Lớp học</span>
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
            include "../Teacher/Tab/dashboardTabUI.php";
            ?>
        </div>

        <div id="classTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "classTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Teacher/Tab/classTabUI.php";
            ?>
        </div>
    </div>
    <script src="teacherUI.js"></script>
</body>
</html>