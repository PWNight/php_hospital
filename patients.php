<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital: Пациенты</title>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>ФИО</td>
                <td>Серия номер паспорта</td>
                <td>Дата рождения</td>
                <td>Домашний адрес</td>
                <td>Номер телефона</td>
                <td>Почта</td>
                <td>Последний приём</td>
            </tr>
            <?php
                include_once 'utils/patient.php';
                $patient = new Patient();
                if(isset($_GET['id'])){
                    $data = json_decode($patient -> showOne($_GET['id']),1);
                    foreach($data as $key => $value){
                        switch($key){
                            case 'appointment_id':
                                if(empty($value)){
                                    echo "<td>Отсутствует</td>";
                                }else{
                                    echo "<td><a href='appointments.php?id=$value'>Посмотреть</a></td>";
                                }
                                break;
                            default:
                                echo "<td>$value</td>";
                                break;
                        }
                    }
                }else{
                    $data = json_decode($patient -> showAll(),1);
                    foreach($data as $key => $value){
                        echo "<tr>";
                        foreach($data[$key] as $key => $value){
                            switch($key){
                                case 'appointment_id':
                                    if(empty($value)){
                                        echo "<td>Отсутствует</td>";
                                    }else{
                                        echo "<td><a href='appointments.php?id=$value'>Посмотреть</a></td>";
                                    }
                                    break;
                                default:
                                    echo "<td>$value</td>";
                                    break;
                            }
                        }
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>