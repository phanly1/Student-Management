<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require_once 'ConnectDB.php';
    include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Model/Teacher.php');
} catch (Exception $e) {
}

class TeacherDAO {
    //MARK: - Get
    public static function getAllTeachers() {
        $connection = getConnection();
        $query = "select * from Teacher";

        $result = $connection->query($query);
        $teachers = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = new Teacher($row["id"], $row["accountID"], $row["gender"], $row["address"], $row["phoneNumber"], $row["birthday"]);
                array_push($teachers, $item);
            }
        }

        $connection->close();
        return $teachers;
    }

    public static function getTeacherBy($id) {
        $connection = getConnection();
        $query = 'select * from Teacher where id = '.$id;
        $result = $connection->query($query);
        $connection->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = new Teacher($row["id"], $row["accountID"], $row["gender"], $row["address"], $row["phoneNumber"], $row["birthday"]);
                return $item;
            }
        }
    }

    public static function getTeacherByAccountID($accountID) {
        $connection = getConnection();
        $query = 'select * from Teacher where accountID = '.$accountID;
        $result = $connection->query($query);
        $connection->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item = new Teacher($row["id"], $row["accountID"], $row["gender"], $row["address"], $row["phoneNumber"], $row["birthday"]);
                return $item;
            }
        }
    }

    // MARK: - Add
    public static function addTeacher($accountID, $gender,$address, $phoneNumber, $birthDay) {
        $connection = getConnection();
        $query = 'insert into Teacher(accountID, gender, address, phoneNumber, birthday) VALUES (?,?,?,?,?)';
        $stmp = $connection->prepare($query);
        $stmp->bind_param("iisss", $accountID, $gender, $address, $phoneNumber, $birthDay);
        $stmp->execute();
    
        $stmp->close();
        $connection->close();
    }

    //MARK: - Delete
    public static function removeTeacher($id) {
        $connection = getConnection();
        $query = 'delete from Teacher where id = ?';
        $stmp = $connection->prepare($query);
        $stmp->bind_param("i", $id);
        $stmp->execute();

        $stmp->close();
        $connection->close();
    }

    //MARK: - Update
    public static function updateTeacher($id, $gender, $address, $phoneNumber, $birthDay) {
        $connection = getConnection();
        $query = 'update Teacher set gender = ?, address = ?, phoneNumber = ?, birthday = ? where id = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("isssi", $gender, $address, $phoneNumber, $birthDay, $id);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp = $connection->prepare($query);
            $connection->close();
        }
    }
}
?>