<?
include_once("utils.php");
    class Employer{
        function add($data){
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fk_doctor"=>$data['fk_doctor'],
                "fk_patient"=>$data['fk_patient'],"type"=>$data['type'],
                "timestamp"=>$data['timestamp'],"file_url"=>$data['file_url']
            ];
            $invalidKeys = [];
            foreach($dataArray as $key=>$value){
                if($value === null){
                    $invalidKeys += [$key=>"$key is empty"];
                }
            }
            if(count($invalidKeys) != 0){
                return jsonMessage(['status'=>false,'message'=>'Someone fields is empty', 'data'=>$invalidKeys]);
            }
            $sql = "INSERT INTO coupons (fk_doctor, fk_patient, type, timestamp, file_url) 
                VALUES (".$data['fk_doctor'].",".$data['fk_patient'].",".
                $data['type'].",".$data['timestamp'].",".$data['file_url']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(['success'=>true,'message'=>'success added medical document']);
        }
        function edit($id,$data){

        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM med_docs WHERE id = $id";
            $result = mysqli_execute_query($conn,$sql);
            if($result){
                return jsonMessage(['success'=>true,'message'=>'success delete medical document']);
            }
            return jsonMessage(['success'=>false,'message'=>'error']);
        }
    }