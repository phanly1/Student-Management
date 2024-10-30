<?php
    function getConnection() {
        $localhost = "localhost";
        $username = "root";
        $password = "";
        $database = "qlsv";

        $conn = mysqli_connect($localhost,$username,$password,$database);
        return $conn;
    }
?>