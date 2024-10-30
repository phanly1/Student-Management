<?php
class Teacher {
    public $id;
    public $accountID;
    public $gender;
    public $address;
    public $phoneNumber;
    public $birthDay;

    public function __construct($id, $accountID, $gender, $address, $phoneNumber, $birthDay) {
        $this->id = $id;
        $this->accountID = $accountID;
        $this->gender = $gender;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
        $this->birthDay = $birthDay;
    }

    public function getID() {
        return $this->id;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function getGender() {
        if ($this->gender == 1) {
            return 'Nữ';
        }

        return 'Nam';
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getBirthDay() {
        return $this->birthDay;
    }
}
?>