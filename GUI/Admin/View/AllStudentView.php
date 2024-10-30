<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../../BLL/adminBLL.php';

navigateIfNeed('admin');
?>
<style>
@import url("https://fonts.googleapis.com/css?family=Lexend Deca");

* {
    font-family: 'Lexend Deca';
}

.studentTable {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
}

.studentTable th {
    text-align: left;
    background-color: black;
    color: white;
}

.studentTable tr {
    height: 40px;
    border-top: 1px solid black;
    
}

tr:not(:last-child) td{
  border-bottom: 1px solid gray;
}

#nav {
    width: 100%;
    height: 50px;
    display: flex;
    align-items: center;
    padding-bottom: 15px;
}

#nav .title {
    font-size: 30px;
    font-weight: bold;
    padding-left: 30px;
}
</style>
<body>
    <div id="nav">
        <i class='bx bx-arrow-back bx-md'></i>
        <p class="title">Danh sách sinh viên</p>
    </div>
    <div class="main">
        <table class="studentTable">
            <tr>
                <th style="text-align: center">Mã sinh viên</th>
                <th>Họ tên sinh viên</th>
                <th>Ngành học</th>
                <th>Email</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th></th>
            </tr>
            <?php
                $students = AdminBLL::allStudent();
                foreach ($students as $student) {
                    $major = AdminBLL::getStudentMajor($student);
                    $name = AdminBLL::getStudentName($student->getID());
                    $email = AdminBLL::getStudentEmail($student->getID());
                    echo '
                    <tr>
                        <td style="text-align: center">'.$student->getID().'</td>
                        <td>'.$name.'</td>
                        <td>'.$major->getName().'</td>
                        <td>'.$email.'</td>
                        <td>'.$student->getGender().'</td>
                        <td>'.$student->getAddress().'</td>
                        <td>'.$student->getPhoneNumber().'</td>
                        <td>'.$student->getBirthDay().'</td>
                        <td>
                            <form action="DetailStudentView.php" method="get">
                            <input  type="hidden"
                                    name="id"
                                    value="'.$student->getID().'">

                            <button type="submit">
                                <i class="bx bxs-edit-alt bx-sm" style="color: blue;" ></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    ';
                }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</body>
<script>
    var element = document.getElementById("nav"); //grab the element
    element.onclick = function() {
        window.location.href = "../adminUI.php";
    }
</script>
</html>