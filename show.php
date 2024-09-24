<?php
$tableName = $_GET['table'] ?? null;
$allowedTables = ['patients', 'employers', 'medicaldocs', 'coupons', 'appointments'];

if ($tableName !== null && in_array($tableName, $allowedTables)) {
    switch ($tableName) {
        case 'patients':
            include_once 'utils/patient.php';
            $patient = new Patient();
            $id = $_GET['id'] ?? null;

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
                $data = $patient->showOne($id);
                if (!empty($data)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($data['fio']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['passport_data']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['birth_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['home_address']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                    echo "<td>" . (empty($data['appointment_id']) ? "Отсутствует" : "<a href='appointments.php?id=" . htmlspecialchars($value['appointment_id']) . "'>Посмотреть</a>") . "</td>";
                    echo "<td><a href='edit.php?table=employers&id=". htmlspecialchars($id) ."'>Редактировать</a>";
                    echo "</tr>";
                } else {
                    echo "<tr><td>Пациент не найден.</td></tr>";
                }
            } else {
                $data = $patient->showAll();
                if (!empty($data)) {
                    foreach ($data as $patientData) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($patientData['fio']) . "</td>";
                        echo "<td>" . htmlspecialchars($patientData['passport_data']) . "</td>";
                        echo "<td>" . htmlspecialchars($patientData['birth_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($patientData['home_address']) . "</td>";
                        echo "<td>" . htmlspecialchars($patientData['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($patientData['email']) . "</td>";
                        echo "<td>" . (empty($patientData['appointment_id']) ? "Отсутствует" : "<a href='appointments.php?id=" . htmlspecialchars($value['appointment_id']) . "'>Посмотреть</a>") . "</td>";
                        echo "<td><a href='edit.php?table=patients&id=". htmlspecialchars($patientData['id']) ."'>Редактировать</a>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td>Пациенты не найдены.</td></tr>";
                }
            }
            echo "</tbody></table>";
            break;
        case 'employers':
            include_once 'utils/employer.php';
            $employer = new Employer();
            $id = $_GET['id'] ?? null;

            echo "<h2>Список сотрудников</h2>";
            echo "<table>";
            echo "<thead>
                    <tr>
                        <td>ФИО</td>
                        <td>Серия номер паспорта</td>
                        <td>Домашний адрес</td>
                        <td>Номер телефона</td>
                        <td>Почта</td>
                        <td>Должность</td>
                        <td>Отдел</td>
                    </tr>
                  </thead>
                  <tbody>";

            if ($id !== null) {
                $data = $employer->showOne($id);
                if (!empty($data)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($data['fio']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['passport_data']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['home_address']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['post_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($data['dep_name']) . "</td>";
                    echo "<td><a href='edit.php?table=employers&id=". htmlspecialchars($id) ."'>Редактировать</a>";
                    echo "</tr>";
                } else {
                    echo "<tr><td>Сотрудник не найден.</td></tr>";
                }
            } else {
                $data = $employer->showAll();
                if (!empty($data)) {
                    foreach ($data as $employerData) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($employerData['fio']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['passport_data']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['home_address']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['post_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($employerData['dep_name']) . "</td>";
                        echo "<td><a href='edit.php?table=employers&id=". htmlspecialchars($employerData['id']) ."'>Редактировать</a>";
                        echo "</tr>";
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
        case 'coupons':
            // Implement logic for coupons
            break;
        case 'appointments':
            // Implement logic for appointments
            break;
    }
} else {
    echo "<p>Неверный запрос.</p>";
}
?>