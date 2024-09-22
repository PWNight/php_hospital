<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital: Результаты приёмов</title>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>ФИО Пациента</td>
                <td>ФИО Врача</td>
                <td>Отдел</td>
                <td>Время начала приёма</td>
                <td>Время окончания</td>
                <td>Жалобы</td>
                <td>Диагноз</td>
                <td>Выписанный документ</td>
                <td>Примечания</td>
            </tr>
            <?php
                include_once("utils/appointment.php");
                $appointment = new Appointment();
                if(isset($_GET['id'])){
                    $data = $appointment -> showOne($_GET['id']);
                    $data = json_decode($data,1);
                    foreach($data as $key => $value){
                        switch($key){
                            case 'fk_meddoc':
                                if(empty($value)){
                                    echo "<td>Отсутствует</td>";
                                }else{
                                    echo "<td><a href='medicaldocs.php?id=$value'>Посмотреть</a></td>";
                                }
                                break;
                            default:
                                echo "<td>$value</td>";
                                break;
                        }
                    }
                }else{
                    $data = $appointment -> showAll();
                    $data = json_decode($data,1);
                    foreach($data as $key => $value){
                        echo "<tr>";
                        foreach($data[$key] as $key => $value){
                            switch($key){
                                case 'fk_meddoc':
                                    if(empty($value)){
                                        echo "<td>Отсутствует</td>";
                                    }else{
                                        echo "<td><a href='medicaldocs.php?id=$value'>Посмотреть</a></td>";
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