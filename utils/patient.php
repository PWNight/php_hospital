<?
include_once('utils.php');
    class Patient{
        function showAll(){
            $conn = conn();
            $sql = "SELECT 
                    p.fio, 
                    p.passport_data, 
                    p.birth_date, 
                    p.home_address, 
                    p.phone_number, 
                    p.email, 
                    a.id AS appointment_id
                FROM 
                    patients p
                LEFT JOIN 
                    appointments a ON p.id = a.fk_patient
                ORDER BY 
                    p.id DESC
            ";
            $result = mysqli_query($conn,$sql);
            $dataArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
            if(empty($dataArray)){
                return jsonMessage(404,['message'=>'Patients not found']);
            }
            return jsonMessage(200,$dataArray);
        }
        function showOne($id){
            if(!isset($id)){
                return jsonMessage(400,['message'=>'Id is empty']);
            }
            $conn = conn();
            $sql = "SELECT 
                    p.fio, 
                    p.passport_data, 
                    p.birth_date, 
                    p.home_address, 
                    p.phone_number, 
                    p.email, 
                    a.id AS appointment_id
                FROM 
                    patients p
                LEFT JOIN 
                    appointments a ON p.id = a.fk_patient
                WHERE 
                    p.id = $id
                ORDER BY 
                    p.id DESC
            ";
            $result = mysqli_query($conn,$sql);
            $dataArray = mysqli_fetch_assoc($result);
            if(empty($dataArray)){
                return jsonMessage(404,['message'=>'Patient not found']);
            }
            return jsonMessage(200,$dataArray);
        }
        function add($data){
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fio"=>$data['fio'],"passport_data"=>$data['passport_data'],
                "home_adress"=>$data['home_adress'],"phone_number"=>$data['phone_number'],
                "email"=>$data['email']
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
            $sql = "INSERT INTO employers (fio, passport_data, home_adress, phone_number, email, fk_position, fk_depart) 
                VALUES (".$data['fio'].",".$data['passport_data'].",".
                $data['home_adress'].",".$data['phone_number'].",".$data['email']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(200,['message'=>'success added employer']);
        }
        function edit($id,$data){

        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM patients WHERE id = $id";
            $result = mysqli_execute_query($conn,$sql);
            if($result){
                return jsonMessage(200,['success'=>true,'message'=>'success delete patient']);
            }
            return jsonMessage(400,['success'=>false,'message'=>'error']);
        }
    }