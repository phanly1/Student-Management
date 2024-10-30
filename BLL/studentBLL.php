<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/Common/commonfunction.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/AccountDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/TeacherDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/StudentDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/ClassDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/ClassDetailDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/ScoreDAO.php');
include($_SERVER['DOCUMENT_ROOT'].'/QuanLySinhVien/DAO/MajorDAO.php');

class StudentBLL {
    public static function getAccountID() {
        return $_SESSION['id'];
    }

    public static function getStudent() {
        $accountID = StudentBLL::getAccountID();
        $student = StudentDAO::getStudentByAccountID($accountID);
        return $student;
    }

    public static function getStudentID() {
        $student = StudentBLL::getStudent();
        return $student->getID();
    }
    //MARK: - Class
    public static function classByID($id) {
        return ClassDAO::getClassBy($id);
    }

    public static function getStudentEmail() {
        $id = StudentBLL::getStudentID();
        $student = StudentDAO::getStudentBy($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getEmail();
    }

    public static function getStudentName() {
        $id = StudentBLL::getStudentID();
        $student = StudentDAO::getStudentBy($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getName();
    }

    public static function getClass() {
        $studentID = StudentBLL::getStudentID();
        $listClasses = ClassDetailDAO::getClassOfStudent($studentID);

        $classes = [];
        foreach ($listClasses as $class) {
            $item = ClassDAO::getClassBy($class->getClassID());
            array_push($classes, $item);
        }

        return $classes;
    }

    //MARK:- Score
    public static function ScoreOfClass($classID) {
        $studentID = StudentBLL::getStudentID();
        $score = ScoreDAO::getScoreOfStudent($classID, $studentID);
        return $score;
    }

    public static function getCountOfScoreWord($word) {
        $count = 0;
        $classes = StudentBLL::getClass();

        for ($i = 0; $i < count($classes); $i++) {
            $class = $classes[$i];
            $score = StudentBLL::ScoreOfClass($class->getID());
            if ($score->getScoreWord() == $word) {
                $count += 1;
            }
        }

        return $count;
    }

    public static function getMajor() {
        $student = StudentBLL::getStudent();
        return MajorDAO::getMajorBy($student->getMajorID());
    }

    public static function majors() {
        return MajorDAO::getAllMajor();
    }

    public static function updateStudent($id, $name, $email,$password, $gender, $address, $phoneNumber, $birthday, $majorID) {
        try {
            $accountID = StudentBLL::getAccountID();
            $account = AccountDAO::getAccountByID($accountID);

            AccountDAO::updateEmail($account->getID(), $email);
            AccountDAO::updateName($account->getID(), $name);

            if (isset($password) && strlen($password) > 0) {
                AccountDAO::updatePassword($account->getID(), $password);
            }

            StudentDAO::updateStudent($id, $gender, $address, $phoneNumber, $birthday, $majorID);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
