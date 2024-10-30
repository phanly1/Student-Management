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

.teacherTable {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
}

.teacherTable th {
    text-align: left;
    background-color: black;
    color: white;
}

.teacherTable tr {
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
        <p class="title">Danh sách giảng viên</p>
    </div>
    <div class="main">
        <table class="teacherTable">
            <tr>
                <th>Mã giảng viên</th>
                <th>Họ tên giảng viên</th>
                <th>Email</th>
                <th>Giới tính</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th></th>
            </tr>
            <?php
                $teachers = AdminBLL::allTeachers();
                foreach ($teachers as $teacher) {
                    echo '
                    <tr>
                        <td>'.$teacher->getID().'</td>
                        <td>'.AdminBLL::getTeacherName($teacher->getID()).'</td>
                        <td>'.AdminBLL::getTeacherEmail($teacher->getID()).'</td>
                        <td>'.$teacher->getGender().'</td>
                        <td>'.$teacher->getAddress().'</td>
                        <td>'.$teacher->getPhoneNumber().'</td>
                        <td>'.$teacher->getBirthDay().'</td>
                        <td>
                            <form action="DetailTeacherView.php" method="get">
                            <input  type="hidden"
                                    name="id"
                                    value="'.$teacher->getID().'">

                            <button type="submit">
                                <i class="bx bxs-edit-alt bx-sm" style="color: blue;" ></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    ';
                }
            ?>
            <td></td>
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