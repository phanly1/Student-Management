<?php
require_once '../../BLL/adminBLL.php';

navigateIfNeed('admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["currentTab"])) {
        $_SESSION["currentTab"] = $_POST["currentTab"];
    } else {
        logout();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="adminUI.css">
</head>
<body>
    <!--Left side bar-->
    <div class="sidebar">
        <div class="logo-content">
            <div class="logo">
                <i class='bx bxs-invader'></i>
                <h3>Admin</h3>
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
                if ($_SESSION["currentTab"] != "studentTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Student" onClick="openTab('studentTab');">
                        <i class='bx bxs-graduation'></i>
                        <span class="links-name">Quản lý sinh viên</span>
                    </a>
                </li>

                <li <?php
                if ($_SESSION["currentTab"] != "teacherTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Teacher" onClick="openTab('teacherTab');">
                        <i class='bx bx-body'></i>
                        <span class="links-name">Quản lý giảng viên</span>
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
                        <span class="links-name">Quản lý lớp học</span>
                    </a>
                </li>

                <li <?php
                if ($_SESSION["currentTab"] != "majorTab") {
                    echo 'class="list-item"';
                } else {
                    echo 'class="list-item active"';
                }
                ?>>
                    <a href="#Class" onClick="openTab('majorTab');">
                        <i class='bx bxs-grid'></i>
                        <span class="links-name">Quản lý ngành học</span>
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
            include "../Admin/Tab/dashboardTabUI.php";
            ?>
        </div>

        <div id="studentTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "studentTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Admin/Tab/studentTabUI.php";
            ?>
        </div>

        <div id="teacherTab" class="tab" 
        <?php
            if ($_SESSION["currentTab"] != "teacherTab") {
                echo 'style="display: none"';
            }
        ?>>
            <?php
            include "../Admin/Tab/teacherTabUI.php";
            ?>
        </div>

        <div id="classTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "classTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Admin/Tab/classTabUI.php";
            ?>
        </div>

        <div id="majorTab" class="tab" <?php
        if ($_SESSION["currentTab"] != "majorTab") {
            echo 'style="display: none"';
        }
        ?>>
            <?php
            include "../Admin/Tab/majorTabUI.php";
            ?>
        </div>
    </div>
    <script src="adminUI.js"></script>
</body>
</html>