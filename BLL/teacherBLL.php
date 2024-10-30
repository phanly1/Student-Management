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


class TeacherBLL {
    //MARK: - Persional Information
    public static function getAccountID() {
        return $_SESSION['id'];
    }

    public static function getTeacher() {
        $accountID = TeacherBLL::getAccountID();
        $student = TeacherDAO::getTeacherByAccountID($accountID);
        return $student;
    }

    public static function getTeacherID() {
        $teacher = TeacherBLL::getTeacher();
        return $teacher->getID();
    }

    public static function getTeacherName() {
        $teacher = TeacherBLL::getTeacher();
        $account = AccountDAO::getAccountByID($teacher->getAccountID());
        return $account->getName();
    }

    public static function getTeacherEmail() {
        $teacher = TeacherBLL::getTeacher();
        $account = AccountDAO::getAccountByID($teacher->getAccountID());
        return $account->getEmail();
    }

    public static function updateTeacher($id, $name, $email,$password, $gender, $address, $phoneNumber, $birthday) {
        try {
            $accountID = TeacherBLL::getAccountID();
            $account = AccountDAO::getAccountByID($accountID);

            AccountDAO::updateEmail($account->getID(), $email);
            AccountDAO::updateName($account->getID(), $name);

            if (isset($password) && strlen($password) > 0) {
                AccountDAO::updatePassword($account->getID(), $password);
            }

            TeacherDAO::updateTeacher($id, $gender, $address, $phoneNumber, $birthday);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //MARK: - Class
    public static function classByID($id) {
        return ClassDAO::getClassBy($id);
    }

    public static function getClass() {
        $teacherID = TeacherBLL::getTeacherID();
        $classes = ClassDAO::getClassOfTeacher($teacherID);

        return $classes;
    }

    public static function getTotalStudents() {
        $classes = TeacherBLL::getClass();
        $students = [];

        foreach ($classes as $class) {
            $studentInClass = TeacherBLL::studentsInClass($class->getID());
            foreach ($studentInClass as $student) {
                $students[$student->getID()] = $student;
            }
        }

        return count($students);
    }

    //MARK: - Detail in Class
    public static function studentsInClass($classID) {
        $list = ClassDetailDAO::getClassDetail($classID);
        $students = [];
        foreach ($list as $item) {
            $student = StudentDAO::getStudentBy($item->getStudentID());
            array_push($students, $student);
        }
    
        return $students;
    }

    //MARK: - Score of student
    public static function ScoreOfStudent($classID, $studentID) {
        return ScoreDAO::getScoreOfStudent($classID, $studentID);
    }

    public static function updateScore($scoreID, $score1, $score2, $score3) {
        ScoreDAO::updateScore($scoreID, $score1, $score2, $score3);
    }

    //MARK: - Student Information
    public static function getStudentName($id) {
        $student = StudentDAO::getStudentBy($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getName();
    }
    public static function getStudentEmail($id) {
        $student = StudentDAO::getStudentBy($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getEmail();
    }
}
?>
