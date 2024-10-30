<style>
.top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
}

.top .card {
    background-color: white;
    border-radius: 20px;
    border: 1px solid black;
    width: calc((100% - 20px * 5) / 4);
    height: 130px;
    padding: 25px;
    display: flex;
	align-items: center;
    justify-content: space-between;
}

.top .card .main .number {
    font-size: 25px;
    font-weight:900;
}
</style>
<div>
    <div class="top">
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php 
                        echo AdminBLL::numberOfStudents();
                    ?>
                </p>
                <p class="title">Sinh viên</p>
            </div>
            <img src="../../resources/image/student.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php 
                        echo AdminBLL::numberOfTeachers();
                    ?>
                </p>
                <p class="title">Giảng viên</p>
            </div>
            <img src="../../resources/image/teacher.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php 
                        echo AdminBLL::numberOfClasses();
                    ?>
                </p>
                <p class="title">Lớp học</p>
            </div>
            <img src="../../resources/image/class.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php 
                        echo count(AdminBLL::majors());
                    ?>
                </p>
                <p class="title">Ngành học</p>
            </div>
            <img src="../../resources/image/majority.png" alt="" style="width: 50px;">
        </div>
    </div>
    <div id='calendar' style="padding: 30px;">
        <?php
        require_once '../../Common/Calendar.php';
        ?>
    </div>
</div>