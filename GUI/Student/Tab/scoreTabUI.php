<style>

    .classTabContent {
        padding: 20px;
    }

    .classTabContent table {
        border-collapse: collapse;
        width: 100%;
    }

    .classTabContent th,
    td {
        text-align: left;
        padding: 8px;
    }

    .classTabContent tr:nth-child(even) {
        background-color: #f2f2f2
    }

    .classTabContent .custom {
        background-color: black;
        color: white;
    }

    table, th, tr, td {
        border: 1px solid black;
    }
</style>
<div class="classTabContent">
    <p style="font-size: 25px; font-weight: bold;">DANH SÁCH ĐIỂM</p><br>
    <table>
        <tr>
            <th>Họ và tên sinh viên</th>
            <td><?php echo $_SESSION["name"]; ?></td>
        </tr>
        <tr>
            <th>Mã sinh viên</t>
            <td><?php echo StudentBLL::getStudentID(); ?></td>
        </tr>
        <tr>
            <th>Ngành học</t>
            <td><?php echo StudentBLL::getMajor()->getName(); ?></td>
        </tr>
    </table><br>
    <div>            
        <?php
        $classes = StudentBLL::getClass();

        if (count($classes) == 0) {
            echo "Hiện tại, sinh viên chưa tham gia vào lớp học nào cả!";
        } else{
            echo '<table>';
            echo '
            <tr>
                <th class="custom">STT</th>
                <th class="custom">Tên lớp</th>
                <th class="custom">Điểm thường xuyên</t>
                <th class="custom">Điểm giữa kì</th>
                <th class="custom">Điểm cuối kì</th>
                <th class="custom">Trung bình môn</th>
                <th class="custom">Điểm chữ</th>
            </tr>
            ';

            for ($i = 0; $i < count($classes); $i++) {
                $class = $classes[$i];
                $score = StudentBLL::ScoreOfClass($class->getID());
                echo '
                    <tr>
                        <td>' . ($i + 1) . '</td>
                        <td>' . $class->getName() . '</td>
                        <td>' . $score->getScore1() . '</td>
                        <td>' . $score->getScore2() . '</td>
                        <td>' . $score->getScore3() . '</td>
                        <td>' . $score->getTotal() . '</td>
                        <td>' . $score->getScoreWord() . '</td>
                    </tr>
                    ';
            }
            echo ' </table>';
        }

        
        ?>
    </div>
</div>