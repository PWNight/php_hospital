<?php
include_once("utils.php");
    class Employer{
        function showAll(): array{
            $conn = conn();
            $sql = "SELECT 
                    e.id,
                    e.fio, 
                    e.passport_data, 
                    e.home_address, 
                    e.phone_number, 
                    e.email, 
                    p.name as post_name,
                    d.name as dep_name
                FROM 
                    employers e
                JOIN 
                    posts p ON p.post_id = e.fk_post
                JOIN 
                    departaments d ON d.dep_id = e.fk_depart";

            $result = mysqli_query($conn,$sql);
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            
            if (empty($data)) {
                return [];
            } else {
                return $data;
            }
        }
        
        function showOne($id): array{
            $conn = conn();
            $sql = "SELECT 
                    e.fio, 
                    e.passport_data, 
                    e.home_address, 
                    e.phone_number, 
                    e.email, 
                    e.fk_post,
                    e.fk_depart,
                    p.name as post_name,
                    d.name as dep_name
                FROM 
                    employers e
                JOIN 
                    posts p ON p.post_id = e.fk_post
                JOIN 
                    departaments d ON d.dep_id = e.fk_depart
                WHERE
                    e.id = $id
            ";
            $result = mysqli_query($conn,$sql);
            $data = mysqli_fetch_assoc($result);
            if (empty($data)) {
                return [];
            } else {
                return $data;
            }
        }
        function add($data){
            /*$data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fio"=>$data['fio'],"passport_data"=>$data['passport_data'],
                "home_address"=>$data['home_address'],
                "phone_number"=>$data['phone_number'],
                "email"=>$data['email'],"fk_position"=>$data['fk_position'],
                "fk_depart"=>$data['fk_depart']
            ];
            $invalidKeys = [];
            foreach($dataArray as $key=>$value){
                if($value === null){
                    $invalidKeys += [$key=>"$key is empty"];
                }
            }
            if(count($invalidKeys) != 0){
                return jsonMessage(400,['message'=>'Someone fields is empty', 'data'=>$invalidKeys]);
            }
            $sql = "INSERT INTO employers (fio, passport_data, home_address, phone_number, email, fk_position, fk_depart) 
                VALUES (".$data['fio'].",".$data['passport_data'].",".
                $data['home_adress'].",".$data['phone_number'].",".
                $data['email'].",".$data['fk_position'].",".
                $data['fk_depart']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(200,['message'=>'Success added employer']);
            */
        }
        function edit(int $id, array $data): bool {
            $fio = $data['fio'] ?? null;
            $passportData = $data['passport_data'] ?? null;
            $homeAddress = $data['home_address'] ?? null;
            $phoneNumber = $data['phone_number'] ?? null;
            $email = $data['email'] ?? null;
            $postId = $data['fk_post'] ?? null;
            $departamentId = $data['fk_depart'] ?? null;
    
            $conn = conn();
            $sql = "UPDATE `employers` SET `fio` = ?,
            `passport_data` = ?, `home_address` = ?,
            `phone_number` = ?, `email` = ?,
            `fk_post` = ?, `fk_depart` = ? WHERE `id` = ?";
    
            $stmt = mysqli_prepare($conn, $sql);
            $bindParams = mysqli_stmt_bind_param($stmt, "sssssssi", $fio, $passportData, $homeAddress, $phoneNumber, $email, $postId, $departamentId, $id);
            
            if ($stmt !== false && $bindParams !== false) {
                return mysqli_stmt_execute($stmt);
            } else {
                return false;
            }
        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM employers WHERE id = $id";
            return mysqli_execute_query($conn,$sql);
        }
    }