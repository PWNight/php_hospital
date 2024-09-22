<?
include_once "utils.php";
    class Coupon{
        function add($data){
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fk_doctor"=>$data['fk_doctor'],
                "fk_patient"=>$data['fk_patient'],
                "datetime"=>$data['datetime'],
                "cabinet"=>$data['cabinet'],"status"=>$data['status']
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
            $sql = "INSERT INTO coupons (fk_doctor, fk_patient, datetime, cabinet, status) 
                VALUES (".$data['fk_doctor'].",".$data['fk_patient'].",".
                $data['datetime'].",".$data['cabinet'].",".$data['status']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(200, ['message'=>'Success added coupon']);
        }
        function edit($id,$data){

        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM coupons WHERE id = $id";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(200,['message'=>'Success delete coupon']);

        }
    }