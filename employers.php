<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital: Работники</title>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>ФИО</td>
                <td>Серия номер паспорта</td>
                <td>Домашний адрес</td>
                <td>Номер телефона</td>
                <td>Почта</td>
                <td>Должность</td>
                <td>Отдел</td>
            </tr>
            <?php
                include_once 'utils/employer.php';
                $employer = new Employer();
                if(isset($_GET['id'])){
                    $data = json_decode($employer -> showOne($_GET['id']),1);
                    foreach($data as $key => $value){
                        echo "<td>$value</td>";
                    }
                }else{
                    $data = json_decode($employer -> showAll(),1);
                    foreach($data as $key => $value){
                        echo "<tr>";
                        foreach($data[$key] as $key => $value){
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>