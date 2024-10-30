<?php
class ClassDetail {
    private $id;
    private $classID;
    private $studentID;

    public function __construct($id, $classID, $studentID) {
        $this->id = $id;
        $this->classID = $classID;
        $this->studentID = $studentID;
    }

    public function getID() {
        return $this->id;
    }

    public function getStudentID() {
        return $this->studentID;
    }

    public function getClassID() {
        return $this->classID;
    }
}
?>