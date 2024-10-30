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
        width: calc((100% - 20px * 4) / 3);
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
    <div class="top">
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    $classes =  StudentBLL::getClass();
                    echo count($classes);
                    ?>
                </p><br>
                <ie class="title">Số lớp học tham gia</p>
            </div>
            <img src="../../resources/image/class.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    echo StudentBLL::getCountOfScoreWord('A');
                    ?>
                </p><br>
                <p class="title">Số điểm A</p>
            </div>
            <img src="../../resources/image/a.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    echo StudentBLL::getCountOfScoreWord('B');
                    ?>
                </p><br>
                <p class="title">Số điểm B</p>
            </div>
            <img src="../../resources/image/b.png" alt="" style="width: 50px;">
        </div>
    </div>
    <div class="top">
    <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    echo StudentBLL::getCountOfScoreWord('C');
                    ?>
                </p><br>
                <p class="title">Số điểm C</p>
            </div>
            <img src="../../resources/image/c.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    echo StudentBLL::getCountOfScoreWord('D');
                    ?>
                </p><br>
                <p class="title">Số điểm D</p>
            </div>
            <img src="../../resources/image/d.png" alt="" style="width: 50px;">
        </div>
        <div class="card">
            <div class="main">
                <p class="number">
                    <?php
                    echo StudentBLL::getCountOfScoreWord('F');
                    ?>
                </p><br>
                <p class="title">Số điểm F</p>
            </div>
            <img src="../../resources/image/f.png" alt="" style="width: 50px;">
        </div>
    </div>
    <div id='calendar' style="padding: 30px;">
        <?php
        require_once '../../Common/Calendar.php';
        ?>
    </div>
</div>