<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../../../BLL/adminBLL.php';

    navigateIfNeed('admin');

    $student = new Student("", "", "", "", "", "", "");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $student = AdminBLL::studentByID($id);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        if (isset($_POST["deleteBtn"])) {
            try {
                AdminBLL::deleteStudent($id);
                echo '<script>
                alert("Xoá thành công!")
                document.location = "/QuanLySinhVien/GUI/Admin/View/AllStudentView.php"
                </script>';
            } catch (Exception $e) {
                echo '<script>
                alert("'.$e->getMessage().'")
                </script>';
            }
        }

        if (isset($_POST["editBtn"])) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $address = $_POST['address'] ?? '';
            $phoneNumber = $_POST['phoneNumber'] ?? '';
            $birthday = $_POST['birthday'] ?? '';
            $password = $_POST['password'] ?? '';
            $majorID = $_POST['major'] ?? '';

            $email = trim($email);
            $name = trim($name);
            $address = trim($address);
            $phoneNumber = trim($phoneNumber);

            $message = "";

            if (!checkEmail($email)) {
                $message .= "Email không đúng. ";
            }

            if (!checkName($name)) {
                $message .= "Tên chứa kí tự đặc biệt. ";
            }

            if (!checkAddress($address)) {
                $message .= "Địa chỉ chứa kí tự đặc biệt. ";
            }

            if (!checkPhoneNumber($phoneNumber)) {
                $message .= "Số điện thoại không đúng. ";
            }

            if (empty($message)) {
                try {
                    AdminBLL::updateStudent($id, $name, $email, $password, $gender, $address, $phoneNumber, $birthday, $majorID);
                    echo '<script>
                    alert("Sửa thành công!")
                    </script>';
                } catch (Exception $e) {
                    echo '<script>
                    alert("'.$e->getMessage().'")
                    </script>';
                }
            } else {
                echo '<script>
                alert("'.$message.'")
                </script>';
            }
        }

        $student = AdminBLL::studentByID($id);
    }
?>
<style>
     @import url("https://fonts.googleapis.com/css?family=Lexend Deca");

    * {
        font-family: 'Lexend Deca';
    }

    #nav {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
    }

    #nav .title {
        font-size: 30px;
        font-weight: bold;
        padding-left: 30px;
    }

    .main {
        padding-left: 60px;
        padding-top: 10px;
    }

    .fieldName {
        font-size: 20px;
        width: 200px;
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
</style>
<body>
    <div id="nav">
        <i class='bx bx-arrow-back bx-md'></i>
        <p class="title">Chi tiết sinh viên</p>
    </div>
    <div class="main">
        <form action="" method="POST">
            <input  type="hidden"
                        name="id"
                        value="<?php echo $student->getID();?>">

            <div class="field">
                <p class="fieldName">Họ tên sinh viên: </p>
                <input type="text" class="textField" name="name" value="<?php echo AdminBLL::getStudentName($student->getID()); ?>" placeholder="Nhập họ và tên" required>
            </div>

            <div class="field">
                <p class="fieldName">Ngành học: </p>
                <script>
                    $(document).ready(function() {
                        $('#major').val('<?php echo $student->getMajorID();?>');
                    });
                </script>
                <select id="major" class="textField" name="major" required>
                    <?php
                        $majors = AdminBLL::majors();
                        foreach ($majors as $major) {
                            echo '<option value="'.$major->getId().'">'.$major->getName().'</option>';
                        } 
                    ?>
                </select>
            </div>

            <div class="field">
                <p class="fieldName">Email: </p>
                <input type="text" class="textField" name="email" value="<?php echo AdminBLL::getStudentEmail($student->getID()); ?>" placeholder="Nhập email" required>
            </div>

            <div class="field">
                <p class="fieldName">Giới tính: </p>
                <script>
                    $(document).ready(function() {
                        $('#gender').val('<?php echo $student->gender;?>');
                    });
                </script>
                <select id="gender" class="textField" name="gender" required>
                    <option value="0">Nam</option>
                    <option value="1">Nữ</option>
                </select>
            </div>

            <div class="field">
                <p class="fieldName">Địa chỉ: </p>
                <input type="text" class="textField" name="address" placeholder="Nhập địa chỉ" value="<?php echo $student->getAddress(); ?>"  required>
            </div>

            <div class="field">
                <p class="fieldName">Số điện thoại: </p>
                <input type="text" class="textField" name="phoneNumber" placeholder="Nhập số điện thoại" value="<?php echo $student->getPhoneNumber(); ?>"  required>
            </div>

            <div class="field">
                <p class="fieldName">Ngày sinh: </p>
                <input type="date" class="textField" name="birthday" value="<?php echo $student->getBirthDay(); ?>" required>
            </div>

            <div class="field">
                <p class="fieldName">Mật khẩu: </p>
                <input  type="password" 
                        class="textField" 
                        placeholder="Nhập mật khẩu" 
                        name="password" 
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
            </div>
            
            <br>
            <button type="submit" 
                    name="editBtn"
                    class="editBtn" 
                    onclick="return confirm('Bạn có chắc muốn sửa sinh viên này không?')"
                    >Edit</button>
            <button type="submit" 
                    name="deleteBtn" 
                    class="deleteBtn"
                    onclick="return confirm('Bạn có chắc muốn xóa sinh viên này không?')"
                    >Delete</button>
        </form>
    </div>
</body>
<script>
    var element = document.getElementById("nav"); //grab the element
    element.onclick = function() {
        window.location.href = "AllStudentView.php";
    }
</script>
</html>