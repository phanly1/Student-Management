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

    /* DIALOG ADD */
    .dialogAdd {
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        opacity: 0;
        pointer-events: none;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        transition: .3s ease;
    }

    .dialogAdd.show {
        opacity: 1;
        pointer-events: auto;
    }

    .modal {
        background-color: white;
        border-radius: 12px;
        padding: 30px 50px;
        width: 600px;
        max-width: 100%;
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

    $class = new SchoolClass("", "", "");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $class = AdminBLL::classByID($id);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $classID = $_POST["classID"];
        $class = AdminBLL::classByID($classID);

        if (isset($_POST["deleteBtn"])) {
            try {
                AdminBLL::deleteClass($classID);
                echo '<script>
                alert("Xoá lớp học thành công!")
                document.location = "/QuanLySinhVien/GUI/Admin/View/AllClassView.php"
                </script>';
            } catch (Exception $e) {
                echo '<script>
                alert("'.$e->getMessage().'")
                </script>';
            }
        }

        if (isset($_POST["editBtn"])) {
            $className = $_POST["classNameNew"];
            $teacherID = $_POST["teacherIDNew"];   
            AdminBLL::updateClass($classID, $className, $teacherID);
            echo '<script>
            alert("Sửa thành công!")
            </script>';
        }

        if (isset($_POST["addStudentBtn"])) {
            $studentID = $_POST["addStudentID"];
            AdminBLL::addStudentInClass($classID, $studentID);
            echo '<script>
            alert("Thêm thành công!")
            </script>';
        }

        if (isset($_POST["removeStudentForm"])) {
            $studentID = $_POST["removeStudentID"];
            AdminBLL::deleteStudentInClass($class->getId(), $studentID);
            echo '<script>
            alert("Xoá thành công!")
            </script>';
        }

        $class = AdminBLL::classByID($classID);
    }
?>
<body>
    <div class="mainContainer">
        <div id="navigation">
            <i class='bx bx-arrow-back bx-md'></i>
            <p class="title">Chi tiết lớp học</p>
        </div>
        <div class="mainView">
            <form class="editView" action="" method="POST">
                <input  type="hidden"
                        name="classID"
                        value="<?php echo $class->getId();?>">

                <div class="field">
                    <p class="fieldName">Tên lớp: </p>
                    <input type="text" class="textField" name="classNameNew" value="<?php echo $class->getName(); ?>" placeholder="Enter class name" required>
                </div>

                <div class="field">
                    <p class="fieldName">Giảng viên phụ trách:</p>
                    <script>
                        $(document).ready(function() {
                            $('#teacherIDNew').val('<?php echo $class->getTeacherID(); ?>');
                        });
                    </script>
                    <select id="teacherIDNew" class="textField" name="teacherIDNew" required>
                        <?php
                            $teachers = AdminBLL::allTeachers();
                            foreach ($teachers as $teacher) {
                                echo '
                                <option value="'.$teacher->getID().'">'.AdminBLL::getTeacherName($teacher->getID())." (id: ".$teacher->getID().")".'</option>
                                ';
                            }
                        ?>
                    </select>
                </div>

                <!-- Edit and Delete button -->
                <button type="submit" 
                        name="editBtn" 
                        class="editBtn"
                        onclick="return confirm('Bạn có chắc muốn sửa lớp này không?')"
                         >Sửa</button>
                <button type="submit" 
                        name="deleteBtn" 
                        class="deleteBtn"
                        onclick="return confirm('Bạn có chắc muốn xóa lớp này không?')"
                        >Xoá</button>
                <br>
            </form>
            <br>
           <!-- Student Table -->
           <div class="allStudent">
                <p class="fieldName" style="font-size: 30px;">Danh sách sinh viên</p>
                <table class="studentTable">
                    <tr>
                        <th style="text-align: center">Mã sinh viên</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ngày sinh</th>
                        <th></th>
                    </tr>
                    <?php
                        $students = AdminBLL::studentsInClass($class->getID());
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
                                <td>
                                    <form action="" method="post">
                                        <input  type="hidden"
                                        name="removeStudentID"
                                        value="'.$student->getID().'">
                                        <input  type="hidden"
                                                name="classID"
                                                value="'.$class->getId().'">

                                        <button type="submit" 
                                                name="removeStudentForm"
                                                onclick="return confirm('."'Bạn có chắc muốn xóa sinh viên này không?'".')">
                                            <i class="bx bx-trash bx-sm" style="color: red;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            ';
                        }

                        echo '
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button id="addStudent" style="border: none; background: white;">
                                        <i class="bx bx-plus-circle bx-sm" style="color: red;"></i>
                                    </button>
                                </td>
                            </tr>';
                    ?>
                </table>
            </div>
        </div>
    </div>
    <!-- DIALOG -->
    <div class="dialogAdd" id="dialogAdd">
        <div class="modal">
            <h1>Thêm sinh viên</h1>
            
            <form action="" method="post">
                <input  type="hidden"
                        name="classID"
                        value="<?php echo $class->getId();?>">

                <p>Sinh viên: </p>
                <select name="addStudentID" id="">
                    <?php
                         $students = AdminBLL::studentWithinClass($class->getId());

                         foreach ($students as $student) {
                            echo '
                            <option value="'.$student->getID().'">'.AdminBLL::getStudentName($student->getID())." (id: ".$student->getID().")".'</option>
                            ';                         
                        }
                    ?>
                    <option value=""></option>
                </select>
                <br><br>
                <button id="close">Đóng</button>
                <button type="submit" name="addStudentBtn">Thêm</button>
            </form>
        </div>
    </div>
</body>
<script>
    var element = document.getElementById("navigation"); //grab the element
    element.onclick = function() {
        window.location.href = "AllClassView.php";
    }

    const open = document.getElementById("addStudent");
    const dialog = document.getElementById("dialogAdd");
    const close = document.getElementById("close");

    open.addEventListener('click', () => {
        dialog.classList.add('show');
    })

    close.addEventListener('click', () => {
        dialog.classList.remove('show');
    })
</script>
</html>