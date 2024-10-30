<style>
    .majorTabContent {
        display: flex;
        align-items: top;
        justify-content: space-between;
        padding: 20px;
    }

    .majorTabContent .table {
        border: 1px solid black;
        border-radius: 20px;
        width: calc((100% - 40px) / 6 * 4);
        height: calc(100%);
        min-height: 500px;
        padding: 10px;
    }

    .majorTabContent .addView {
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

    .addMajorBtn {
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
    function viewAllMajor() {
        window.location.href = "../Admin/View/AllMajorView.php";
    }
</script>
<div class="majorTabContent">
    <div class="addView">
        <p class="headerTitle">Thêm ngành học</p>

        <div class="main">
            <form action="/QuanLySinhVien/BLL/adminBLL.php" method="POST">
                <input type="hidden" name="addMajorForm" value="yes" >
                <p class="fieldName">Tên ngành</p>
                <input type="text" class="textField" name="majorName" placeholder="Nhập tên ngành học" required><br>
                <button type="submit" name="addMajorBtn" class="addMajorBtn" >Thêm</button>
            </form>
        </div>
    </div>

    <div class="table">
        <div class="tableHeader">
            <p class="headerTitle">Danh sách ngành học</p>
            <button class="viewAllBtn" onclick="viewAllMajor();">Xem tất cả</button>
        </div>

        <div class="main">
            <table class="classTable">
                <tr>
                    <th style="text-align: center; border-radius: 10px 0px 0px 0px;">Mã ngành</th>
                    <th>Tên ngành</th>
                    <th style="border-radius: 0px 10px 0px 0px;">Số lượng sinh viên</th>
                </tr>
                <?php
                    $majors = AdminBLL::majors();
                    foreach ($majors as $major) {
                        echo '
                        <tr>
                            <td>'.$major->getId().'</td>
                            <td>'.$major->getName().'</td>
                            <td>'.count(AdminBLL::studentInMajor($major->getId())).'</td>
                        </tr>
                        ';
                    }
                ?>
            </table>
        </div>
    </div>
</div>