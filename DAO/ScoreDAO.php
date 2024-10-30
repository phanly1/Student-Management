<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Model/Score.php');

class ScoreDAO {
    //MARK: - Get
    public static function getScoreOfStudent($classID, $studentID) {
        $connection = getConnection();
        $query = "select * from Score where classID = ? and studentID = ?";

        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("ii", $classID, $studentID);
            $stmp->execute();
            $result = $stmp->get_result();


            if ($result->num_rows > 0) {
                $rawItem = $result->fetch_assoc();
                $item = new Score($rawItem['id'], $rawItem['studentID'], $rawItem['classID'], $rawItem['score1'], $rawItem['score2'], $rawItem['score3']);
                return $item;
            } else {
                $item = new Score(null, $studentID, $classID, null,null, null);
                return $item;
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    //MARK: - Delete
    public static function removeScoreOfStudent($studentID) {
        $connection = getConnection();
        $query = 'delete from Score where studentID = ?';
        
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("i", $studentID);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    public static function removeScoreOfClass($classID) {
        $connection = getConnection();
        $query = 'delete from Score where classID = ?';
        
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("i", $classID);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    //MARK: - Add 
    public static function addScore($studentID,$classID,$score1, $score2, $score3) {        
        $connection = getConnection();
        $query = "insert into Score(studentID, classID, score1, score2, score3) values (?,?,?,?,?)";
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("iiddd", $studentID, $classID, $score1, $score2, $score3);
            $stmp->execute();
            return $stmp->insert_id;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp->close();
            $connection->close();
        }
    }

    //MARK: - Update
    public static function updateScore($id,$score1, $score2, $score3) {
        $connection = getConnection();
        $query = 'update Score set score1 = ?, score2 = ?, score3 = ? where id = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("dddi", $score1, $score2, $score3, $id);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp = $connection->prepare($query);
            $connection->close();
        }
    }

    public static function getAllClasses() {
        $connection = getConnection();
        $query = "select * from Class";
    
        $result = $connection->query($query);
        $classes = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $class = new SchoolClass($row["id"], $row["name"], $row["teacherID"]);
                array_push($classes, $class);
            }
        }
    
        return $classes;
    }

    public static function addClass($name, $teacherID) {
        $connection = getConnection();
        $query = 'insert into Class(name, teacherID) VALUES (?,?)';
        $stmp = $connection->prepare($query);
        $stmp->bind_param("si", $name, $teacherID);
        $stmp->execute();
    
        $stmp->close();
        $connection->close();
    }

    public static function getClassBy($id) {
        $connection = getConnection();
        $query = 'select * from Class where id = '.$id;
        $result = $connection->query($query);
        $connection->close();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = new SchoolClass($row["id"], $row["name"], $row["teacherID"]);
                return $item;
            }
        }
    }

    public static function updateClass($classID, $className, $teacherID) {
        $connection = getConnection();
        $query = 'update Class set teacherID = ?, name = ? where id = ?';
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("isi", $teacherID, $className, $classID);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }
}
?>