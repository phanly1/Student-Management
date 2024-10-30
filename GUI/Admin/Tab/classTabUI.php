<style>
    .classTabContent {
        display: flex;
        align-items: top;
        justify-content: space-between;
        padding: 20px;
    }

    .classTabContent .table {
        border: 1px solid black;
        border-radius: 20px;
        width: calc((100% - 40px) / 6 * 4);
        height: calc(100%);
        min-height: 500px;
        padding: 10px;
    }

    .classTabContent .addView {
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

    .addClasstBtn {
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
    .classTable {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
    }

    .classTable th {
        text-align: center;
        background-color: black;
        color: white;
        min-width: 20px;

    }

    .classTable tr {
        height: 40px;
        border-bottom: 1px solid black;
        text-align: center;
    }

    tr:not(:last-child) td{
    border-bottom: 1px solid gray;
    }

</style>
<script>
    function viewAllClasses() {
        window.location.href = "../Admin/View/AllClassView.php";
    }
</script>
<div class="classTabContent">
    <div class="addView">
        <p class="headerTitle">Thêm lớp học</p>

        <div class="main">
            <form action="/QuanLySinhVien/BLL/adminBLL.php" method="POST">
                <input type="hidden" name="addClassForm" value="yes" >
                <p class="fieldName">Tên lớp</p>
                <input type="text" class="textField" name="className" placeholder="Nhập tên lớp học" required>
                <p class="fieldName">Giảng viên</p>
                <select id="gender" class="textField" name="teacherID" required>
                    <?php
                        $teachers = AdminBLL::allTeachers();
                        foreach ($teachers as $teacher) {
                            echo '
                            <option value="'.$teacher->getID().'">'.AdminBLL::getTeacherName($teacher->getID())." (mã giảng viên: ".$teacher->getID().")".'</option>
                            ';
                        }
                    ?>
                </select><br>
                <button type="submit" name="addClasstBtn" class="addClasstBtn" >Thêm</button>
            </form>
        </div>
    </div>

    <div class="table">
        <div class="tableHeader">
            <p class="headerTitle">Danh sách lớp học</p>
            <button class="viewAllBtn" onclick="viewAllClasses();">Xem tất cả</button>
        </div>

        <div class="main">
                <?php
                    $classes = AdminBLL::allClasses();

                    if (empty($classes)) {
                        echo 'Hiện tại chưa có lớp học nào!';
                    } else {
                        echo '
                        <table class="classTable">
                            <tr>
                                <th style="text-align: center; border-radius: 10px 0px 0px 0px;">Mã lớp</th>
                                <th>Tên lớp</th>
                                <th>Giảng viên phụ trách</th>
                                <th style="border-radius: 0px 10px 0px 0px;">Số lượng sinh viên</th>
                            </tr>
                        ';
                        foreach ($classes as $class) {
                            echo '
                            <tr>
                                <td>'.$class->getId().'</td>
                                <td>'.$class->getName().'</td>
                                <td>'.AdminBLL::getTeacherName($class->getTeacherID()).'</td>
                                <td>'.AdminBLL::numberOfStudentInClass($class->getId()).'</td>
                            </tr>
                            ';
                        }

                        echo '</table>';
                    }
                ?>
        </div>
    </div>
</div>