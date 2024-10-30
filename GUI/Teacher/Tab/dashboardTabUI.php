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
    width: calc((100% - 20px * 3) / 2);
    height: 130px;
    padding: 25px;
    display: flex;
	align-items: center;
    justify-content: space-between;
}

.top .card .main .number {
        font-size: 25px;
        font-weight: bold;
    }

</style>
<div>
    <div>
        <div class="top">
            <div class="card">
                <div class="main">
                    <p class="number">
                        <?php 
                            echo count(TeacherBLL::getClass());
                        ?>
                    </p>
                    <p class="title">Số lượng lớp dạy</p>
                </div>
                <img src="../../resources/image/class.png" alt="" style="width: 50px;">
            </div>
            <div class="card">
                <div class="main">
                    <p class="number">
                        <?php 
                            echo TeacherBLL::getTotalStudents();
                        ?>
                    </p>
                    <p class="title">Số lượng học sinh</p>
                </div>
                <img src="../../resources/image/student.png" alt="" style="width: 50px;">
            </div>
        </div>
        <div id='calendar' style="padding: 30px;">
            <?php
                require_once '../../Common/Calendar.php';
            ?>
        </div>
    </div>
</div>