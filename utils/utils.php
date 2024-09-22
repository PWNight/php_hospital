<?php
    function conn(){
        $conn = mysqli_connect("localhost","root","root","hospital");
        if(!$conn){
            die("". mysqli_connect_error());
        }
        return $conn;
    }
    function jsonMessage($code,$body){
        $json = json_encode($body,true);
        http_response_code($code);
        return $json;
    }