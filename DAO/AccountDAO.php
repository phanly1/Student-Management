<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    require_once 'ConnectDB.php';
    include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Model/Account.php');
} catch (Exception $e) {
}

class AccountDAO {
    //MARK: - Get
    public static function isExitsAccount($email): bool {
        $connection = getConnection();
        $query = "select * from Account where email = '$email'";
        $result = $connection->query($query);
        $connection->close();
        
        if ($result->num_rows > 0) {
            return true;
        } 
        
        return false;
    }

    public static function getAccount($email) {
        $connection = getConnection();
        $query = "select * from Account where email = '$email'";
        $result = $connection->query($query);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $item = new Account($row["id"], $row["name"], $row["email"], $row["password"], $row["role"]);
            $connection->close();
            return $item;
        }
    }

    public static function getAccountByID($id) {
        $connection = getConnection();
        $query = "select * from Account where id = '$id'";
        $result = $connection->query($query);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $item = new Account($row["id"], $row["name"], $row["email"], $row["password"], $row["role"]);
            $connection->close();
            return $item;
        }
    }

    //MARK: - Add
    public static function addAccount($name,$email,$password,$role) {
        $connection = getConnection();
        $query = "insert into Account(name, email, password, role) values (?,?,?,?)";
        $stmp = $connection->prepare($query);

        try {
            $newPassword = sha1($password);
            $stmp->bind_param("ssss", $name, $email, $newPassword, $role);
            $stmp->execute();
            return $stmp->insert_id;
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp->close();
            $connection->close();
        }
    }

    //MARK: - Delete
    public static function removeAccount($id) {
        $connection = getConnection();
        $query = 'delete from Account where id = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("i", $id);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp->close();
            $connection->close();
        }
    } 

    //MARK: - Update
    public static function updateName($id, $name) {
        $connection = getConnection();
        $query = 'update Account set name = ? where id = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("si", $name, $id);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp = $connection->prepare($query);
            $connection->close();
        }
    }

    public static function updateEmail($id, $email) {
        $connection = getConnection();
        $query = 'update Account set email = ? where id = ?';
        try {
            $stmp = $connection->prepare($query);
            $stmp->bind_param("si", $email, $id);
            $stmp->execute();
            $stmp->close();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $connection->close();
        }
    }

    public static function updatePassword($id, $password) {
        $connection = getConnection();
        $hashValue = sha1($password);
        $query = 'update Account set password = ? where id = ?';
        $stmp = $connection->prepare($query);

        try {
            $stmp->bind_param("si", $hashValue, $id);
            $stmp->execute();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        } finally {
            $stmp->close();
            $connection->close();
        }
    }
}
?>