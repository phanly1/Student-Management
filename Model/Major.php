<?php
class Major {
    // id int(11) not null AUTO_INCREMENT primary key,
    // name longtext not null,
    // teacherID int(11) not null
    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}
?>