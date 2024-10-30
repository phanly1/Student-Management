<?php 
class Score {
    private $id;
    private $studentID;
    private $classID;
    private $score1;
    private $score2;
    private $score3;

    public function __construct($id, $studentID, $classID, $score1, $score2, $score3) {
        $this->id = $id;
        $this->studentID = $studentID;
        $this->classID = $classID;
        $this->score1 = $score1;
        $this->score2 = $score2;
        $this->score3 = $score3;
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

    public function getScore1() {
        return $this->score1;
    }

    public function getScore2() {
        return $this->score2;
    }

    public function getScore3() {
        return $this->score3;
    }

    public function getTotal() {
        if (isset($this->score1) && isset($this->score2) && isset($this->score3)) {
            $total = $this->score1 * 0.15 + $this->score2 * 0.35 + $this->score3 * 0.5;
            return $total;
        }

        return null;
    }

    public function getScoreWord() {
        $total = $this->getTotal();
        if (isset($total)) {
            if ($total >= 8) {
                return 'A';
            } else if ($total >= 7) {
                return 'B';
            } else if ($total >= 6) {
                return 'C';
            } else if ($total >= 5) {
                return 'D';
            } else {
                return 'F';
            }
        }

        return null;
    }
}
?>