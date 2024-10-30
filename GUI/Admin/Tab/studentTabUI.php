<style>
    .studentTabContent {
        display: flex;
        align-items: top;
        justify-content: space-between;
        padding: 20px;
    }

    .studentTabContent .table {
        border: 1px solid black;
        border-radius: 20px;
        width: calc((100% - 40px) / 6 * 4);
        height: calc(100%);
        min-height: 500px;
        padding: 10px;
    }

    .studentTabContent .addView {
        border: 1px solid black;
        border-radius: 20px;
        width: calc((100% - 40px) / 6 * 2);
        height: 100%;
        padding: 10px;
    }

    .headerTitle {
        font-size: 25px;
        font-weight: bolder;
    }

    .addView .main {
        padding: 10px;
    }

    .textField {
        display: flex;
        width: 100%;
        height: 35px;
    }

    .fieldName {
        padding-top: 10px;
        padding-bottom: 5px;
    }

    .addStudentBtn {
        width: 100%;
        height: 40px;
        background-color: black;
        color: white;
        border-radius: 10px;
    }

    .tableHeader {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 20px;
    }

    .viewAllBtn {
        width: 100px;
        height: 30px;
        background-color: black;
        color: white;
        border-radius: 5px;
    }

    /* TABLE */
    .studentTable {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
    }

    .studentTable th {
        text-align: left;
        background-color: black;
        color: white;
        min-width: 20px;
    }

    .studentTable tr {
        height: 40px;
        border-bottom: 1px solid black;
    }

    tr:not(:last-child) td{
    border-bottom: 1px solid gray;
    }
</style>
<script>
    function viewAllStudent() {
        window.location.href = "../Admin/View/AllStudentView.php";
    }
</script>
<div class="studentTabContent">
    <div class="addView">
        <p class="headerTitle">Thêm sinh viên</p>

        <div class="main">
            <form action="/QuanLySinhVien/BLL/adminBLL.php" method="POST">
                <input type="hidden" name="addStudentForm" value="yes" >
                <!-- Name -->
                <p class="fieldName">Họ và tên</p>
                <input type="text" class="textField" name="studentName" placeholder="Nhập họ và tên" required>

                <p class="fieldName">Ngành học</p>
                <select class="textField" name="majorID" required>
                    <?php
                        $majors = AdminBLL::majors();
                        foreach ($majors as $major) {
                            echo '<option value="'.$major->getId().'">'.$major->getName().'</option>';
                        } 
                    ?>
                </select>

                <!-- Email -->
                <p class="fieldName">Email</p>
                <input type="text" class="textField" name="studentEmail" placeholder="Nhập email" required>

                <!-- Gender -->
                <p class="fieldName">Giới tính</p>
                <select class="textField" name="studentGender" required>
                    <option value="0">Nam</option>
                    <option value="1">Nữ</option>
                </select>

                <!-- Address -->
                <p class="fieldName">Địa chỉ</p>
                <input type="text" class="textField" placeholder="Nhập địa chỉ" name="studentAddress" required>

                <!-- Phone -->
                <p class="fieldName">Số điện thoại</p>
                <input type="text" class="textField" placeholder="Nhập số điện thoại" name="studentPhoneNumber" required>

                <!-- Birthday -->
                <p class="fieldName">Ngày sinh</p>
                <input type="date" class="textField" name="studentBirthday" required>

                <!-- Password -->
                <p class="fieldName">Mật khẩu</p>
                <input  type="password" 
                        class="textField" 
                        placeholder="Nhập mật khẩu" 
                        name="studentPassword" 
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        required>
                <br>
                <button type="submit" name="addStudentBtn" class="addStudentBtn" >Thêm</button>
            </form>
        </div>
    </div>

    <div class="table">
        <div class="tableHeader">
            <p class="headerTitle">Danh sách sinh viên</p>
            <button class="viewAllBtn" onclick="viewAllStudent();">Xem tất cả</button>
        </div>

        <div class="main">
            <table class="studentTable">
                <tr>
                    <th style="text-align: center; border-radius: 10px 0px 0px 0px;">Mã sinh viên</th>
                    <th>Họ tên sinh viên</th>
                    <th>Email</th>
                    <th style="border-radius: 0px 10px 0px 0px;">Số điện thoại</th>
                </tr>
                <?php
                    $students = AdminBLL::allStudent();
                    foreach ($students as $student) {
                        echo '
                        <tr>
                            <td style="text-align:center;">'.$student->getID().'</td>
                            <td>'.AdminBLL::getStudentName($student->getID()).'</td>
                            <td>'.AdminBLL::getStudentEmail($student->getID()).'</td>
                            <td>'.$student->getPhoneNumber().'</td>
                        </tr>
                        ';
                    }
                ?>
            </table>
        </div>
    </div>
</div>