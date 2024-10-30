<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Model/ClassDetail.php');

class ClassDetailDAO {
    //MARK: - Get
    public static function getAllClassDetails() {
        $connection = getConnection();
        $query = "select * from ClassDetail";
    
        $result = $connection->query($query);
        $details = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detail = new ClassDetail($row["id"], $row["classID"], $row["studentID"]);
                array_push($details, $detail);
            }
        }
    
        return $details;
    }
    public static function getClassDetail($classID) {
        $connection = getConnection();
        $query = "select * from ClassDetail where classID = ".$classID;

        $result = $connection->query($query);
        $details = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detail = new ClassDetail($row["id"], $row["classID"], $row["studentID"]);
                array_push($details, $detail);
            }
        }

        return $details;
    }

    public static function getClassOfStudent($studentID) {
        $connection = getConnection();
        $query = "select * from ClassDetail where studentID = ".$studentID;

        $result = $connection->query($query);
        $details = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $detail = new ClassDetail($row["id"], $row["classID"], $row["studentID"]);
                array_push($details, $detail);
            }
        }

        return $details;
    }

    public static function removeStudentInClass($classID, $studentID) {
        $connection = getConnection();
        $query = 'delete from ClassDetail where classID = ? and studentID = ?';
        
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("ii", $classID, $studentID);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    //MARK: - Delete
    public static function removeStudent($studentID) {
        $connection = getConnection();
        $query = 'delete from ClassDetail where studentID = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("i", $studentID);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp->close();
            $connection->close();
        }
    }

    public static function removeClassDetailWithClassID($classID) {
        $connection = getConnection();
        $query = 'delete from ClassDetail where classID = ?';
        
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
    public static function addClassDetail($classID, $studentID) {
        $connection = getConnection();
        $query = 'insert into ClassDetail(classID, studentID) VALUES (?, ?)';
        
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("ii", $classID, $studentID);
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