<?php
$actionType = $_GET['action'] ?? null;
$tableName = $_GET['table'] ?? null;
$uId = $_GET['id'] ?? null;

$allowedTables = ['patients', 'employers', 'medicaldocs', 'coupons', 'appointments'];
$allowedAction = ['add','edit','delete'];

$valid = $tableName !== null && $uId !== null && $actionType !== null && in_array($tableName, $allowedTables) && in_array($actionType, $allowedAction);
if ($valid) {
    switch($tableName){
        case 'patients':
            include_once('utils/patient.php');
            $patient = new Patient();

            switch($actionType){
                case 'add':
                    break;
                case 'edit':
                    if($patient -> edit($uId,$_POST)){
                        header('Location: show.php?table=patients');
                    }else{
                        echo "Ошибка при выполнении запроса.";
                    }
                    break;
                case 'delete':
                    break;
            }
            break;
        case 'employers':
            include_once('utils/employer.php');
            $employer = new Employer();
            
            switch($actionType){
                case 'add':
                    break;
                case 'edit':
                    $employer -> edit($uId,$_POST);
                    header('Location: show.php?table=employers');
                    break;
                case 'delete':
                    break;
            }
            break;
    }
} else {
    echo "<p>Неверный запрос.</p>";
}
?>