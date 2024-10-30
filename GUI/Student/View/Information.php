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

    .editBtn {
        background: blue;
        font-size: 20px;
        font-weight: bold;
        color: white;
        height: 50px;
        width: 100px;
        border-radius: 10px;
    }

    .mainView table {
    border-collapse: collapse;
    width: 100%;
    }

    .mainView th, td {
    text-align: left;
    padding: 8px;
    }

    .mainView tr:nth-child(even){background-color: #f2f2f2}

    .mainView .custom {
    background-color: black;
    color: white;
    }

    table, th, tr, td {
        border: 1px solid black;
        font-size: 14px;
    }

    .textField {
        width: 100%;
        height: 100%;
        border: none;
        background-color: rgba(0, 0, 0, 0);
    }

    .imageView {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-bottom: 10px;
    }

    .submitView {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-bottom: 10px;
    }

    .imageView img {
        width: 300px;
        height: 300px;
        object-fit: cover;
    }  
</style>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../../../BLL/studentBLL.php';

    navigateIfNeed('student');

    $student = StudentBLL::getStudent();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["editBtn"])) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $address = $_POST['address'] ?? '';
            $phoneNumber = $_POST['phoneNumber'] ?? '';
            $birthday = $_POST['birthday'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                StudentBLL::updateStudent($student->getID(), $name, $email, $password, $gender, $address, $phoneNumber, $birthday, $student->majorID);
                echo '<script>
                alert("Sửa thành công!")
                </script>';
            } catch (Exception $e) {
                echo '<script>
                alert("'.$e->getMessage().'")
                </script>';
            }
        }

        $student = StudentBLL::getStudent();
    }
?>
</style>
<body>
    <div class="mainContainer">
        <div id="navigation">
            <i class='bx bx-arrow-back bx-md'></i>
            <p class="title">Thông tin cá nhân</p>
        </div>

        <div class="imageView">
            <img src="../../../resources/image/student.png" alt="">
        </div>
        
        <div class="mainView">
            <form class="editView" action="" method="POST">
                <table class="infoTB">
                    <tr>
                        <th>Mã sinh viên</th>
                        <td><?php echo $student->getID(); ?></td>
                    </tr>

                    <tr>
                        <th>Họ và tên sinh viên</th>
                        <td>
                            <input type="text" class="textField" name="name" id="" value="<?php echo StudentBLL::getStudentName(); ?>">
                        </td>
                    </tr>

                    <tr>
                        <th>Ngành học</th>
                        <td>
                            <?php
                                echo StudentBLL::getMajor()->getName();
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>
                            <input type="text" class="textField" name="email" value="<?php echo StudentBLL::getStudentEmail(); ?>" placeholder="Enter email" required>
                        </td>
                    </tr>

                    <tr>
                        <th>Giới tính</th>
                        <td>
                            <script>
                                $(document).ready(function() {
                                    $('#gender').val('<?php echo $student->gender;?>');
                                });
                            </script>
                            <select class="textField" name="gender" id="gender"  required>
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Địa chỉ</th>
                        <td>
                        <input type="text" class="textField" name="address" placeholder="Enter address" value="<?php echo $student->getAddress(); ?>"  required>
                        </td>
                    </tr>

                    <tr>
                        <th>Số điện thoại</th>
                        <td>
                        <input type="text" class="textField" name="phoneNumber" placeholder="Enter phone number" value="<?php echo $student->getPhoneNumber(); ?>"  required>
                        </td>
                    </tr>

                    <tr>
                        <th>Ngày sinh</th>
                        <td>
                        <input type="date" class="textField" name="birthday" value="<?php echo $student->getBirthDay(); ?>" required>
                        </td>
                    </tr>

                    <tr>
                        <th>Mật khẩu</th>
                        <td>
                            <input  type="password" 
                                    class="textField" 
                                    placeholder="Nhập mật khẩu" 
                                    name="password" 
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        </td>
                    </tr>
                </table> <br>   
                
                <div class="submitView">
                    <button type="submit" 
                        name="editBtn"
                        class="editBtn" 
                        onclick="return confirm('Bạn có chắc muốn sửa không?')"
                        >Sửa</button>
                </div>  
            </form><br>          
        </div>
    </div>
</body>
<script>
    var element = document.getElementById("navigation"); //grab the element
    element.onclick = function() {
        window.location.href = "../studentUI.php";
    }
</script>
</html>