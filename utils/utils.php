<?php
    function conn(){
        $conn = mysqli_connect("localhost","root","root","hospital");
        if(!$conn){
            die("". mysqli_connect_error());
        }
        return $conn;
    }