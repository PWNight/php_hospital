<?
    class Schelude{
        function add($data){
            $data = json_decode($data,1);
            $conn = conn();

            $dataArray = ["fk_employer"=>$data['fk_employer'],
                "date"=>$data['date'],
                "time_from"=>$data['time_from'],
                "time_to"=>$data['time_to'],"cabinet"=>$data['cabinet']
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
            
            $sql = "INSERT INTO schelude (fk_employer, date, time_from, time_to, cabinet) 
                VALUES (".$data['fk_employer'].",".$data['date'].",".
                $data['time_from'].",".$data['time_to'].",".$data['cabinet']
            .")";
            mysqli_execute_query($conn,$sql);
            return jsonMessage(['success'=>true,'message'=>'success added schelude']);
        }
        function edit($id,$date,$data){
            $conn = conn();
            $result = mysqli_execute_query($conn,"SELECT * FROM schelude WHERE fk_employer = $id AND date = $date",MYSQL_ASSOC);
            $rows = mysqli_fetch_all($result);
            if(count($rows) == 0){
                return jsonMessage(['success'=>false,'message'=>'schelude for this employer and this date not found']);
            }
        }
        function delete($id){
            $conn = conn();
            $sql = "DELETE FROM schelude WHERE fk_employer = $id";
            return mysqli_execute_query($conn,$sql);
        }
    }