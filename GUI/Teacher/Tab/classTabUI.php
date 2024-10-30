<style>
@import url("https://fonts.googleapis.com/css?family=Poppins");

.classTabContent {
    padding: 20px;
}

.classTabContent table {
  border-collapse: collapse;
  width: 100%;
}

.classTabContent th, td {
  text-align: left;
  padding: 8px;
}

.classTabContent tr:nth-child(even){background-color: #f2f2f2}

.classTabContent .custom {
  background-color: black;
  color: white;
}

table, th, tr, td {
    border: 1px solid black;
}


</style>
<div class="classTabContent"> 
    <p style="font-size: 25px; font-weight: bold;">DANH SÁCH LỚP HỌC</p><br>
    <table>
        <tr>
            <th>Họ và tên giảng viên</th>
            <td><?php echo  $_SESSION["name"];?></td>
        </tr>
        <tr>
            <th>Mã giảng viên</t>
            <td><?php echo TeacherBLL::getTeacherID();?></td>
        </tr>
        <tr>
            <th>Số lượng lớp dạy</t>
            <td><?php echo count(TeacherBLL::getClass());?></td>
        </tr>
    </table>
    <br>
    <div>            
        <?php
            $classes = TeacherBLL::getClass();

            if (count($classes) == 0) {
                echo "Hiện tại, giảng viên chưa phụ trách lớp học nào cả!";
            } else{
                echo '<table>';
                echo '
                <tr>
                    <th class="custom">STT</th>
                    <th class="custom">Mã lớp</th>
                    <th class="custom">Tên lớp</th>
                    <th class="custom">Action</t>
                </tr>
                ';

                for ($i = 0; $i < count($classes); $i++) {
                    $class = $classes[$i];

                    echo '
                    <tr>
                        <td>'.($i + 1).'</td>
                        <td>'.$class->getID().'</td>
                        <td>'.$class->getName().'</td>
                        <td>
                            <form action="../Teacher/View/DetailClassView.php" method="get">
                            <input  type="hidden"
                                    name="id"
                                    value="'.$class->getId().'">

                            <button type="submit">
                                <i class="bx bxs-edit-alt bx-sm" style="color: blue;" ></i>
                            </button>
                        </form>
                    </tr>
                    ';
                }

                echo ' </table>';
            }
        ?>
    </div>
</div>