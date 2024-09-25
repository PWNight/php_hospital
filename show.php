<?php
$tableName = $_GET['table'] ?? null;
$allowedTables = ['patients', 'employers', 'medicaldocs', 'appointments'];

if ($tableName !== null && in_array($tableName, $allowedTables)) {
    $classTableName = substr($tableName,0,-1);
    include_once "utils/{$classTableName}.php";
    
    $className = ucfirst($classTableName);
    $entity = new $className();
    $id = $_GET['id'] ?? null;
    
    function displayRows($data,$tableName){
        echo "<tr>";

        if($tableName === 'patients' || $tableName === 'employers'){
            echo "<td>" . htmlspecialchars($data['fio']) . "</td>";
            echo "<td>" . htmlspecialchars($data['passport_data'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($data['birth_date'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($data['home_address'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($data['phone_number'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($data['email'] ?? '') . "</td>";

            if ($tableName === 'patients') {
                echo "<td>" . (empty($data['appointment_id']) ? "Отсутствует" : "<a href='show.php?table=appointments&id=" . htmlspecialchars($data['appointment_id']) . "'>Посмотреть</a>") . "</td>";
            } elseif ($tableName === 'employers') {
                echo "<td>" . htmlspecialchars($data['post_name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($data['dep_name'] ?? '') . "</td>";
            }
        }else{
            echo "<td>" . htmlspecialchars($data['patient_fio']) . "</td>";
            echo "<td>" . htmlspecialchars($data['doctor_fio']) . "</td>";
            echo "<td>" . htmlspecialchars($data['depart_name']) . "</td>";
            echo "<td>" . htmlspecialchars($data['timestamp_start']) . "</td>";
            echo "<td>" . htmlspecialchars($data['timestamp_end']) . "</td>";
            echo "<td>" . htmlspecialchars($data['complaints']) . "</td>";
            echo "<td>" . htmlspecialchars($data['diagnosis']) . "</td>";
            if(empty(htmlspecialchars($data['diagnosis']))){
                echo "<td>Отсутствует</td>";
            }else{
                echo "<td><a href='show.php?table=medicaldocs&id=". htmlspecialchars($data['diagnosis']) . "'>Посмотреть</a></td>";
            }
        }
        echo "<td><a href='edit.php?table={$tableName}&id=" . htmlspecialchars($data['id']) . "'>Редактировать</a></td>";
        echo "</tr>";
    }
    switch ($tableName) {
        case 'patients':
            echo "<h2>Список пациентов</h2>";
            echo "<table>";
            echo "<thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Серия номер паспорта</th>
                        <th>Дата рождения</th>
                        <th>Домашний адрес</th>
                        <th>Номер телефона</th>
                        <th>Почта</th>
                        <th>Последний приём</th>
                    </tr>
                  </thead>
                  <tbody>";

            if ($id !== null) {
                $data = $entity->showOne($id);
                if (!empty($data)) {
                    displayRows($data,$tableName);
                } else {
                    echo "<tr><td>Пациент не найден.</td></tr>";
                }
            } else {
                $data = $entity->showAll();
                if (!empty($data)) {
                    foreach ($data as $entityData) {
                        displayRows($entityData,$tableName);
                    }
                } else {
                    echo "<tr><td>Пациенты не найдены.</td></tr>";
                }
            }
            echo "</tbody></table>";
            break;
        case 'employers':
            echo "<h2>Список сотрудников</h2>";
            echo "<table>";
            echo "<thead>
                    <tr>
                        <td>ФИО</td>
                        <td>Серия номер паспорта</td>
                        <th>Дата рождения</th>
                        <td>Домашний адрес</td>
                        <td>Номер телефона</td>
                        <td>Почта</td>
                        <td>Должность</td>
                        <td>Отдел</td>
                    </tr>
                  </thead>
                  <tbody>";

            if ($id !== null) {
                $data = $entity->showOne($id);
                if (!empty($data)) {
                    displayRows($data,$tableName);
                } else {
                    echo "<tr><td>Сотрудник не найден.</td></tr>";
                }
            } else {
                $data = $entity->showAll();
                if (!empty($data)) {
                    foreach ($data as $entityData) {
                        displayRows($entityData,$tableName);
                    }
                } else {
                    echo "<tr><td>Сотрудники не найдены.</td></tr>";
                }
            }
            echo "</tbody></table>";
            break;
        case 'medicaldocs':
            // Implement logic for medical documents
            break;
        case 'appointments':
            echo "<h2>Список посещений</h2>";
            echo "<table>";
            echo "<thead>
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
                  </thead>
                  <tbody>";

            if ($id !== null) {
                $data = $entity->showOne($id);
                if (!empty($data)) {
                    $data['id'] = $id;
                    displayRows($data,$tableName);
                } else {
                    echo "<tr><td>Посещение не найдено.</td></tr>";
                }
            } else {
                $data = $entity->showAll();
                if (!empty($data)) {
                    displayRows($data,$tableName);
                } else {
                    echo "<tr><td>Посещения не найдены.</td></tr>";
                }
            }
            echo "</tbody></table>";
            break;
    }
} else {
    echo "<p>Неверный запрос.</p>";
}
?>