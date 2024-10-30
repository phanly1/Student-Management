<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../DAO/AccountDAO.php';

session_start();

// Handle Login Action
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = trim($email);

    if (AccountDAO::isExitsAccount($email)) {
        $account = AccountDAO::getAccount($email);

        if ($account->getPassword() == sha1($password)) {
            $_SESSION["didLogin"] = true;
            $_SESSION["role"] = $account->getRole();
            $_SESSION["name"] = $account->getName();
            $_SESSION["id"] = $account->getID();
    
            $_SESSION["currentTab"] = "dashboardTab";
    
            echo '<script>
            alert("Đăng nhập thành công!")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        } else {
            $error = "Mật khẩu sai. Vui lòng đăng nhập lại!";
            echo '<script>
            alert("'.$error.'")
            document.location = "/QuanLySinhVien/index.php"
            </script>'; 
        }
    } else {
        $error = "Tài khoản không tồn tại. Vui lòng đăng nhập lại!";
        echo '<script>
        alert("'.$error.'")
        document.location = "/QuanLySinhVien/index.php"
        </script>'; 
    }
    return;
}

header("Location: /QuanLySinhVien/index.php");
?>