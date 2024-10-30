<?php
session_start();

function navigateIfNeed($role) { 
    if (isset($_SESSION["didLogin"])) {
        if ($_SESSION["didLogin"]) {
            if ($_SESSION["role"] != $role) {
                header("Location: /QuanLySinhVien/index.php");
            }
        } else {
            header("Location: /QuanLySinhVien/index.php");
        }
    } else {
        header("Location: /QuanLySinhVien/index.php");
    }
}

function logout() {
    session_unset();
    header("Location: /QuanLySinhVien/index.php");
}

//MARK:- Validate
function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function checkName($name) {
    return !containsSpecialChars($name);
}

function checkPhoneNumber($sdt) {
    $re = '/^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/m';
    preg_match_all($re, $sdt, $matches, PREG_SET_ORDER, 0);
    return count($matches) > 0;
}

function checkAddress($address) {
    return !containsSpecialChars($address);
}

function containsSpecialChars($str) {
    return false;
}
?>