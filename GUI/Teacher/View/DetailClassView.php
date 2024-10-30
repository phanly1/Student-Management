<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Class</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    * {
        font-family: 'Times New Roman', Times, serif;
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

    .fieldName {
        font-size: 20px;
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

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, th, tr, td {
        border: 1px solid black;
    }

    .studentTable tr {
        height: 40px;
    }

    td {
        text-align: center;
    }

    input {
        width: calc(100% - 10px);
        height: 40px;
        border: none;
    }
</style>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../../../BLL/teacherBLL.php';
    navigateIfNeed('teacher');

    $class = new SchoolClass("", "", "");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        $class = TeacherBLL::classByID($id);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $classID = $_POST["classID"];    
        $class = TeacherBLL::classByID($classID);

        $students = TeacherBLL::studentsInClass($class->getID());
        foreach ($students as $student) {
            $score = TeacherBLL::ScoreOfStudent($class->getID(), $student->getID());
            $score1 = ((isset($_POST["score1+". $student->getID()]) && !empty($_POST["score1+". $student->getID()])) ? $_POST["score1+". $student->getID()] : NULL);
            $score2 = ((isset($_POST["score2+". $student->getID()]) && !empty($_POST["score2+". $student->getID()])) ? $_POST["score2+". $student->getID()] : NULL);
            $score3 = ((isset($_POST["score3+". $student->getID()]) && !empty($_POST["score3+". $student->getID()])) ? $_POST["score3+". $student->getID()] : NULL);

            TeacherBLL::updateScore($score->getID(), $score1, $score2, $score3);
        }
    }
?>
<body>
    <div class="mainContainer">
        <div id="navigation">
            <i class='bx bx-arrow-back bx-md'></i>
            <p class="title">Chi tiết lớp học</p>
        </div>
        <div class="mainView">
            <div class="field">
                    <p class="fieldName">Mã lớp: <?php echo $class->getID(); ?></p>
                </div>
                <div class="field">
                    <p class="fieldName">Tên lớp: <?php echo $class->getName(); ?></p>
                </div>
           <!-- Student Table -->
           <form action="" method="post">
            <input  type="hidden"
                        name="classID"
                        value="<?php echo $class->getID();?>">
            <div class="allStudent">
                    <table class="studentTable">
                        <tr>
                            <th style="text-align: center">Mã sinh viên</th>
                            <th>Tên sinh viên</th>
                            <th>Điểm thường xuyên</t>
                            <th>Điểm giữa kì</th>
                            <th>Điểm cuối kì</th>
                            <th>Trung bình môn</th>
                            <th>Điểm chữ</th>
                        </tr>
                        <?php
                            $students = TeacherBLL::studentsInClass($class->getID());
                            foreach ($students as $student) {
                                $score = TeacherBLL::ScoreOfStudent($class->getID(), $student->getID());
                                
                                echo '
                                <tr>
                                    <td style="text-align: center">'.$student->getID().'</td>
                                    <td>'.TeacherBLL::getStudentName($student->getID()).'</td>
                                    <td>
                                        <input type="text" name="score1+'.$student->getID().'" id="" value="'.$score->getScore1().'" placeholder="Enter score">
                                    </td>
                                    <td>
                                        <input type="text" name="score2+'.$student->getID().'" id="" value="'.$score->getScore2().'" placeholder="Enter score">
                                    </td>
                                    <td>
                                        <input type="text" name="score3+'.$student->getID().'" id="" value="'.$score->getScore3().'" placeholder="Enter score">
                                    </td>
                                    <td>'.$score->getTotal().'</td>
                                    <td>'.$score->getScoreWord().'</td>
                                </tr>
                                ';
                            }
                        ?>
                    </table>
                    <br>
                    <button type="submit" 
                        name="editBtn"
                        class="editBtn" 
                        >Sửa</button>
                </div>
           </form>
        </div>
    </div>
</body>
<script>
    var element = document.getElementById("navigation"); //grab the element
    element.onclick = function() {
        window.location.href = "../teacherUI.php";
    }
</script>
</html>