<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Model/Class.php');

class ClassDAO {

    //MARK: - Get
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

    public static function getClassOfTeacher($teacherID) {
        $connection = getConnection();
        $query = "select * from Class where teacherID = ".$teacherID;

        $result = $connection->query($query);
        $classes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = new SchoolClass($row["id"], $row["name"], $row["teacherID"]);
                array_push($classes, $item);
            }
        }

        return $classes;
    }

    //MARK: - Add
    public static function addClass($name, $teacherID) {
        $connection = getConnection();
        $query = 'insert into Class(name, teacherID) VALUES (?,?)';
        $stmp = $connection->prepare($query);
        $stmp->bind_param("si", $name, $teacherID);

        try {            
            if ($stmp->execute()) {
                return "Thêm thành công!";
            } else {
                return "Tên lớp học đã tồn tại. Vui lòng nhập tên lớp học khác!";
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        } finally {
            $stmp->close();
            $connection->close();
        }
    }

    //MARK: - Remove
    public static function removeClass($id) {
        $connection = getConnection();
        $query = 'delete from Class where id = ?';
        
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("i", $id);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    
    //MARK: - Update
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