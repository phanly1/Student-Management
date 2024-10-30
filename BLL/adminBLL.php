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


class AdminBLL {
    public static function getName() {
        $name = $_SESSION["name"];
        return $name;
    }
    //MARK: - Major
    public static function majors() {
        return MajorDAO::getAllMajor();
    }

    public static function majorByID($majorID) {
        return MajorDAO::getMajorBy($majorID);
    }

    public static function addMajor($name) {
        return MajorDAO::addMajor($name);
    }

    public static function studentInMajor($majorID) {
        $students = StudentDAO::getStudentsByMajorID($majorID);
        return $students;
    }

    public static function deleteMajor($id) {
        try {
            MajorDAO::removeMajor($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function updateMajor($id, $name) {
        try {
            MajorDAO::updateMajor($id, $name);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //MARK: - Teacher
    // - GET
    public static function numberOfTeachers() {
        $teachers = TeacherDAO::getAllTeachers();
        return count($teachers);
    }

    public static function allTeachers() {
        return TeacherDAO::getAllTeachers();
    }

    public static function teacherByID($id) {
        return TeacherDAO::getTeacherBy($id);
    }

    public static function getTeacherName($id) {
        $teacher = AdminBLL::teacherByID($id);
        $account = AccountDAO::getAccountByID($teacher->getAccountID());
        return $account->getName();
    }

    public static function getTeacherEmail($id) {
        $teacher = AdminBLL::teacherByID($id);
        $account = AccountDAO::getAccountByID($teacher->getAccountID());
        return $account->getEmail();
    }

    // - SET
    public static function deleteTeacher($id) {
        $teacher = TeacherDAO::getTeacherBy($id);

        try {
            TeacherDAO::removeTeacher($id);
            AccountDAO::removeAccount($teacher->getAccountID());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function addTeacher($teacherName, $teacherEmail,$teacherPassword, $teacherGender, $teacherAddress, $teacherPhoneNumber, $teacherBirthday) {
        $accountID = "";

        try {
            $accountID = AccountDAO::addAccount($teacherName, $teacherEmail, $teacherPassword, "teacher");
            TeacherDAO::addTeacher($accountID, $teacherGender, $teacherAddress, $teacherPhoneNumber, $teacherBirthday);
        } catch (Exception $e) {
            AccountDAO::removeAccount($accountID);
            throw $e;
        }
    }

    public static function updateTeacher($id, $teacherName, $teacherEmail,$teacherPassword, $teacherGender, $teacherAddress, $teacherPhoneNumber, $teacherBirthday) {
        try {
            $teacher = AdminBLL::teacherByID($id);
            $account = AccountDAO::getAccountByID($teacher->getAccountID());

            AccountDAO::updateEmail($account->getID(), $teacherEmail);
            AccountDAO::updateName($account->getID(), $teacherName);

            if (isset($teacherPassword) && !empty($teacherPassword)) {
                AccountDAO::updatePassword($account->getID(), $teacherPassword);
            }

            TeacherDAO::updateTeacher($id, $teacherGender, $teacherAddress, $teacherPhoneNumber, $teacherBirthday);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //MARK: - Student
    public static function numberOfStudents() {
        $students = StudentDAO::getAllStudents();
        return count($students);
    }

    public static function allStudent() {
        return StudentDAO::getAllStudents();
    }

    public static function studentByID($id) {
        return StudentDAO::getStudentBy($id);
    }

    public static function getStudentName($id) {
        $student = AdminBLL::studentByID($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getName();
    }
    public static function getStudentEmail($id) {
        $student = AdminBLL::studentByID($id);
        $account = AccountDAO::getAccountByID($student->getAccountID());
        return $account->getEmail();
    }

    public static function getStudentMajor($student) {
        return MajorDAO::getMajorBy($student->getMajorID());
    }

    public static function deleteStudent($id) {
        $student = StudentDAO::getStudentBy($id);
        
        try {
            ScoreDAO::removeScoreOfStudent($id);
            ClassDetailDAO::removeStudent($id);
            StudentDAO::removeStudent($id);
            AccountDAO::removeAccount($student->getAccountID());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function addStudent($name, $email,$password, $gender, $address, $phoneNumber, $birthday, $majorID) {
        $accountID = "";

        try {
            $accountID = AccountDAO::addAccount($name, $email, $password, "student");
            StudentDAO::addStudent($accountID, $majorID, $gender, $address, $phoneNumber, $birthday);
        } catch (Exception $e) {
            AccountDAO::removeAccount($accountID);
            throw $e;
        }
    }

    public static function updateStudent($id, $name, $email,$password, $gender, $address, $phoneNumber, $birthday, $majorID) {
        try {
            $student = AdminBLL::studentByID($id);
            $account = AccountDAO::getAccountByID($student->getAccountID());

            AccountDAO::updateEmail($account->getID(), $email);
            AccountDAO::updateName($account->getID(), $name);

            if (isset($password) && !empty($password)) {
                AccountDAO::updatePassword($account->getID(), $password);
            }

            StudentDAO::updateStudent($id, $gender, $address, $phoneNumber, $birthday, $majorID);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //MARK: - Class
    public static function numberOfClasses() {
        $classes = ClassDAO::getAllClasses();
        return count($classes);
    }

    public static function allClasses() {
        return ClassDAO::getAllClasses();
    }
    public static function classByID($id) {
        return ClassDAO::getClassBy($id);
    }

    public static function deleteClass($id) {
        try {
            ClassDetailDAO::removeClassDetailWithClassID($id);
            ClassDAO::removeClass($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function updateClass($classID, $className, $teacherID) {
        try {
            ClassDAO::updateClass($classID, $className, $teacherID);
        } catch (Exception $e) {
            echo '<script>
            alert("'.$e->getMessage().'")
            </script>';
        }
    }

    //MARK: - ClassStudent
    public static function numberOfStudentInClass($classID) {
        $list = ClassDetailDAO::getClassDetail($classID);
        return count($list);
    }

    public static function studentsInClass($classID) {
        $list = ClassDetailDAO::getClassDetail($classID);
        $students = [];
        foreach ($list as $item) {
            $student = StudentDAO::getStudentBy($item->getStudentID());
            array_push($students, $student);
        }
    
        return $students;
    }

    public static function studentWithinClass($classID) {
        $allStudent = AdminBLL::allStudent();
        $studentInClass = AdminBLL::studentsInClass($classID);
        $ans = [];
    
        foreach ($allStudent as $student) {
            if (!in_array($student, $studentInClass)) {
                array_push($ans, $student);
            }
        }
    
        return $ans;
    }

    public static function deleteStudentInClass($classID, $studentID) {
        try {
            ScoreDAO::removeScoreOfStudent($studentID, $classID);
            ClassDetailDAO::removeStudentInClass($classID, $studentID);
        } catch (Exception $e) {
            echo '<script>
            alert("'.$e->getMessage().'")
            </script>';
        }
    }
    
    public static function addStudentInClass($classID, $studentID) {
        try {
            ClassDetailDAO::addClassDetail($classID, $studentID);
            ScoreDAO::addScore($studentID, $classID, null, null, null);
        } catch (Exception $e) {
            echo '<script>
            alert("'.$e->getMessage().'")
            </script>';
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addTeacherForm"])) {
        $teacherName = $_POST['teacherName'] ?? '';
        $teacherEmail = $_POST['teacherEmail'] ?? '';
        $teacherGender = $_POST['teacherGender'] ?? '';
        $teacherAddress = $_POST['teacherAddress'] ?? '';
        $teacherPhoneNumber = $_POST['teacherPhoneNumber'] ?? '';
        $teacherBirthday = $_POST['teacherBirthday'] ?? '';
        $teacherPassword = $_POST['teacherPassword'] ?? '';

        $teacherEmail = trim($teacherEmail);
        $teacherName = trim($teacherName);
        $teacherAddress = trim($teacherAddress);
        $teacherPhoneNumber = trim($teacherPhoneNumber);

        $message = "";

        if (!checkEmail($teacherEmail)) {
            $message .= "Email không đúng. ";
        }

        if (!checkName($teacherName)) {
            $message .= "Tên chứa kí tự đặc biệt. ";
        }

        if (!checkAddress($teacherAddress)) {
            $message .= "Địa chỉ chứa kí tự đặc biệt. ";
        }

        if (!checkPhoneNumber($teacherPhoneNumber)) {
            $message .= "Số điện thoại không đúng. ";
        }

        if (empty($message)) {
            try {
                AdminBLL::addTeacher($teacherName, $teacherEmail, $teacherPassword, $teacherGender, $teacherAddress, $teacherPhoneNumber, $teacherBirthday);
                echo '<script>
                alert("Thêm thành công!")
                document.location = "/QuanLySinhVien/index.php"
                </script>';
            } catch (Exception $e) {
                echo '<script>
                alert("'.$e->getMessage().'")
                document.location = "/QuanLySinhVien/index.php"
                </script>';
            }
        } else {
            echo '<script>
            alert("'.$message.'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        }
    }

    if (isset($_POST["addStudentForm"])) {
        $name = $_POST['studentName'] ?? '';
        $email = $_POST['studentEmail'] ?? '';
        $gender = $_POST['studentGender'] ?? '';
        $address = $_POST['studentAddress'] ?? '';
        $phoneNumber = $_POST['studentPhoneNumber'] ?? '';
        $birthday = $_POST['studentBirthday'] ?? '';
        $password = $_POST['studentPassword'] ?? '';
        $majorID = $_POST['majorID'];

        $email = trim($email);
        $name = trim($name);
        $address = trim($address);
        $phoneNumber = trim($phoneNumber);

        $message = "";

        if (!checkEmail($email)) {
            $message .= "Email không đúng. ";
        }

        if (!checkName($name)) {
            $message .= "Tên chứa kí tự đặc biệt. ";
        }

        if (!checkAddress($address)) {
            $message .= "Địa chỉ chứa kí tự đặc biệt. ";
        }

        if (!checkPhoneNumber($phoneNumber)) {
            $message .= "Số điện thoại không đúng. ";
        }

        if (empty($message)) {
            try {
                AdminBLL::addStudent($name, $email, $password, $gender, $address, $phoneNumber, $birthday, $majorID);
                echo '<script>
                alert("Thêm thành công!")
                document.location = "/QuanLySinhVien/index.php"
                </script>';
            } catch (Exception $e) {
                echo '<script>
                alert("'.$e->getMessage().'")
                document.location = "/QuanLySinhVien/index.php"
                </script>';
            }
        } else {
            echo '<script>
            alert("'.$message.'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        }
    }

    if (isset($_POST["addClassForm"])) {
        $className = $_POST['className'] ?? '';
        $teacherID = $_POST['teacherID'] ?? '';

        try {
            $message = ClassDAO::addClass($className, $teacherID);
            echo '<script>
            alert("'.$message.'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        } catch (Exception $e) {
            echo '<script>
            alert("'.$e->getMessage().'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        }
    }

    if (isset($_POST["addMajorForm"])) {
        $name = $_POST['majorName'] ?? '';

        try {
            $message = AdminBLL::addMajor($name);
            echo '<script>
            alert("'.$message.'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        } catch (Exception $e) {
            echo '<script>
            alert("'.$e->getMessage().'")
            document.location = "/QuanLySinhVien/index.php"
            </script>';
        }
    }
}
?>