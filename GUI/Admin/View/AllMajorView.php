<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Classes</title>
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
.classTable {
    width: 100%;
    height: 100%;
    border-collapse: collapse;
}

.classTable th {
    text-align: left;
    background-color: black;
    color: white;
}

.classTable tr {
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
        <p class="title">Danh sách ngành học</p>
    </div>
    <div class="main">
        <table class="classTable">
            <tr>
                <th>Mã ngành học</th>
                <th>Tên ngành học</th>
                <th>Số lượng sinh viên</th>
                <th></th>
            </tr>
            <?php
                $majors = AdminBLL::majors();
                foreach ($majors as $major) {
                    echo '
                    <tr>
                        <td>'.$major->getId().'</td>
                        <td>'.$major->getName().'</td>
                        <td>'.count(AdminBLL::studentInMajor($major->getId())).'</td>
                        <td>
                            <form action="DetailMajorView.php" method="get">
                            <input  type="hidden"
                                    name="id"
                                    value="'.$major->getId().'">

                            <button type="submit">
                                <i class="bx bxs-edit-alt bx-sm" style="color: blue;" ></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    ';
                }
            ?>
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