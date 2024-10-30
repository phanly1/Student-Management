<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    @import url("https://fonts.googleapis.com/css?family=Lexend Deca");

    * {
        font-family: 'Lexend Deca';
    }

    /* MAIN VIEW */
    /* Navigation */
    #navigation {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
    }

    #navigation .title {
        font-size: 30px;
        font-weight: bold;
        padding-left: 30px;
    }

    .mainView {
        padding-left: 60px;
        padding-right: 60px;
        padding-top: 10px;
    }

    .fieldName {
        font-size: 20px;
        width: 350px;
    }

    .field {
        display: flex;
        align-items: center;
    }

    .textField {
        height: 40px;
        width: 250px;
    }

    .editBtn {
        background: blue;
        font-size: 20px;
        font-weight: bold;
        color: white;
        height: 50px;
        width: 100px;
        border-radius: 10px;
    }

    .deleteBtn {
        background: red;
        font-size: 20px;
        font-weight: bold;
        color: white;
        height: 50px;
        width: 100px;
        border-radius: 10px;
    }

    .studentTable {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
    }

    .studentTable th {
        text-align: center;
        background-color: black;
        color: white;
    }

    .studentTable tr {
        height: 40px;
        border-bottom: 1px solid black;
    }

    tr:not(:last-child) td{
    border-bottom: 1px solid gray;
    }

    td {
        text-align: center;
    }
</style>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../../../BLL/adminBLL.php';

    navigateIfNeed('admin');

    $major = new Major("", "");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $major = AdminBLL::majorByID($id);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        
        if (isset($_POST["deleteBtn"])) {
            try {
                AdminBLL::deleteMajor($id);
                echo '<script>
                alert("Xoá thành công!")
                document.location = "/QuanLySinhVien/GUI/Admin/View/AllMajorView.php"
                </script>';
            } catch (Exception $e) {
                echo '
                <script>
                    alert("Không thể xoá vì còn một số sinh viên học ngành này!")
                </script>
                ';
            }
        }

        if (isset($_POST["editBtn"])) {
            $majorName = $_POST["majorName"];
            try {
                MajorDAO::updateMajor($id, $majorName);
                echo '<script>
                alert("Sửa thành công!")
                </script>';
            } catch (Exception $e) {
                echo '
                <script>
                    alert("Không thể xoá vì còn một số sinh viên học ngành này!")
                </script>
                ';
            }
        }

        $major = AdminBLL::majorByID($id);
    }
?>
<body>
    <div class="mainContainer">
        <div id="navigation">
            <i class='bx bx-arrow-back bx-md'></i>
            <p class="title">Chi tiết ngành học</p>
        </div>
        <div class="mainView">
            <form action="" method="POST">
            <!-- Information of Class -->
                <input  type="hidden"
                        name="id"
                        value="<?php echo $major->getId();?>">

                <div class="field">
                    <p class="fieldName">Tên ngành học: </p>
                    <input type="text" class="textField" name="majorName" value="<?php echo $major->getName(); ?>" placeholder="Nhập tên ngành học" required>
                </div>

                <!-- Edit and Delete button -->
                <button type="submit" 
                        name="editBtn" 
                        class="editBtn" 
                        onclick="return confirm('Bạn có chắc muốn sửa ngành này không?')"
                        >Sửa</button>

                <button type="submit" 
                        name="deleteBtn" 
                        class="deleteBtn"
                        onclick="return confirm('Bạn có chắc muốn xóa ngành này không?')"
                        >Xoá</button>
                <br>
            </form><br>
           <!-- Student Table -->
           <div class="allStudent">
                <p class="fieldName" style="font-size: 30px;">Danh sách sinh viên</p>
                <?php
                    $students = AdminBLL::studentInMajor($major->getId());

                    if (count($students) == 0) {
                        echo 'Chưa có sinh viên nào!';
                    } else {
                        echo '<table class="studentTable">';
                        echo '
                        <tr>
                            <th style="text-align: center">Mã sinh viên</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Ngày sinh</th>
                        </tr>';

                        foreach ($students as $student) {
                            echo '
                            <tr>
                                <td style="text-align: center">'.$student->getID().'</td>
                                <td>'.AdminBLL::getStudentName($student->getID()).'</td>
                                <td>'.AdminBLL::getStudentEmail($student->getID()).'</td>
                                <td>'.$student->getGender().'</td>
                                <td>'.$student->getAddress().'</td>
                                <td>'.$student->getPhoneNumber().'</td>
                                <td>'.$student->getBirthDay().'</td>
                            </tr>
                            ';
                        }

                        echo '</table>';
                    }
                ?>
            </div>
        </div>
    </div>
</body>
<script>
    var element = document.getElementById("navigation"); //grab the element
    element.onclick = function() {
        window.location.href = "AllMajorView.php";
    }
</script>
</html>