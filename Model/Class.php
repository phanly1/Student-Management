<?php
class SchoolClass {
    // id int(11) not null AUTO_INCREMENT primary key,
    // name longtext not null,
    // teacherID int(11) not null
    public $id;
    public $name;
    public $teacherID;
    public function __construct($id, $name, $teacherID) {
        $this->id = $id;
        $this->name = $name;

        $this->teacherID = $teacherID;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    public function getTeacherID() {
        return $this->teacherID;
    }
}
?>