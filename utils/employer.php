<?
include_once("utils.php");
    class Employer{
        function add($data){
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fio"=>$data['fio'],"passport_data"=>$data['passport_data'],
                "home_adress"=>$data['home_adress'],
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
                return jsonMessage(['status'=>false,'message'=>'Someone fields is empty', 'data'=>$invalidKeys]);
            }
            $sql = "INSERT INTO employers (fio, passport_data, home_adress, phone_number, email, fk_position, fk_depart) 
                VALUES (".$data['fio'].",".$data['passport_data'].",".
                $data['home_adress'].",".$data['phone_number'].",".
                $data['email'].",".$data['fk_position'].",".
                $data['fk_depart']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(['success'=>true,'message'=>'success added employer']);
        }
        function edit($id,$data){

        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM employers WHERE id = $id";
            $result = mysqli_execute_query($conn,$sql);
            if($result){
                return jsonMessage(['success'=>true,'message'=>'success delete employer']);
            }
            return jsonMessage(['success'=>false,'message'=>'error']);
        }
    }