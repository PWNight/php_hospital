<?php
include_once 'utils.php';
    class Appointment{
        function showAll(){
            $conn = conn();
            $sql = "SELECT 
                a.id,
                p.fio AS patient_fio,
                e.fio AS doctor_fio,
                d.name AS depart_name,
                a.timestamp_start,
                a.timestamp_end,
                a.complaints,
                a.diagnosis,
                a.fk_meddoc,
                a.note
                
            FROM 
                appointments a
            JOIN 
                patients p ON a.fk_patient = p.id
            JOIN 
                employers e ON a.fk_doctor = e.id
            JOIN
                departaments d ON a.fk_depart = d.dep_id
            ";
            $result = mysqli_query($conn,$sql);
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if(empty($data)){
                return [];
            }
            return $data;
        }
        function showOne($id){
            $conn = conn();
            $sql = "SELECT 
                    p.fio AS patient_fio,
                    e.fio AS doctor_fio,
                    d.name AS depart_name,
                    a.timestamp_start,
                    a.timestamp_end,
                    a.complaints,
                    a.diagnosis,
                    a.fk_meddoc,
                    a.note
                
                FROM 
                    appointments a
                JOIN 
                    patients p ON a.fk_patient = p.id
                JOIN 
                    employers e ON a.fk_doctor = e.id
                JOIN
                    departaments d ON a.fk_depart = d.dep_id
                WHERE a.id = $id
            ";
            $result = mysqli_query($conn,$sql);
            $data = mysqli_fetch_assoc($result);
            if(empty($data)){
                return [];
            }
            return $data;
        }
        function add($data){
            /*
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fk_patient"=>$data['fk_patient'],"fk_doctor"=>$data['fk_doctor'],
                "timestamp_start"=>$data['timestamp_start'],"timestamp_end"=>$data['timestamp_end'],
                "fk_depart"=>$data['fk_depart'],"complaints"=>$data['complaints'],
                "diagnosis"=>$data['diagnosis'],"fk_meddoc"=>$data['fk_meddoc'],
                "note"=>$data['note']
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
            $sql = "INSERT INTO appointments (fk_patient, fk_doctor, timestamp_start, timestamp_end, fk_depart, 
                complaints, diagnosis, fk_meddoc, note) 
                VALUES (".$data['fk_patient'].",".$data['fk_doctor'].",".
                $data['timestamp_start'].",".$data['timestamp_end'].",".
                $data['fk_depart'].",".$data['complaints'].",".
                $data['diagnosis'].",".$data['fk_meddoc'].",".$data['note']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(200,['message'=>'success added appointment']);
            */
        }
        function edit($id,$data){

        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM appointments WHERE id = $id";
            return mysqli_execute_query($conn,$sql);
        }
    }