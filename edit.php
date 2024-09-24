<?php
$tableName = $_GET['table'] ?? null;

$allowedTables = ['patients', 'employers', 'medicaldocs', 'coupons', 'appointments'];

if ($tableName !== null && in_array($tableName, $allowedTables)) {
    switch ($tableName) {
        case 'patients':
            include_once 'utils/patient.php';
            $patient = new Patient();
            $id = $_GET['id'] ?? null;
            if ($id !== null) {
                $data = $patient->showOne($id);
                if (!empty($data)) {
                    echo "<form action='actionsHandler.php?action=edit&table=patients&id=$id' method='post' enctype='multipart/form-data'>";
                    echo "<input type='text' name='fio' value='" . htmlspecialchars($data['fio']) . "'>";
                    echo "<input type='text' name='passport_data' value='" . htmlspecialchars($data['passport_data']) . "'>";
                    echo "<input type='date' name='birth_date' value='" . htmlspecialchars($data['birth_date']) . "'>";
                    echo "<input type='text' name='home_address' value='" . htmlspecialchars($data['home_address']) . "'>";
                    echo "<input type='text' name='phone_number' value='" . htmlspecialchars($data['phone_number']) . "'>";
                    echo "<input type='email' name='email' value='" . htmlspecialchars($data['email']) . "'>";
                    echo "<input type='submit' value='Сохранить'>";
                    echo "</form>";
                } else {
                    echo "<p>Пациент не найден.</p>";
                }
            }else{
                echo "<p>Некорректный запрос.";
            }
            break;
        case 'employers':
            include_once 'utils/employer.php';
            $employer = new Employer();
            $id = $_GET['id'] ?? null;
            if ($id !== null) {
                $data = $employer->showOne($id);
                if (!empty($data)) {
                    echo "<form action='actionsHandler.php?action=edit&table=employers&id=$id' method='POST'>";
                    echo "<input type='text' name='fio' value='" . htmlspecialchars($data['fio']) . "'>";
                    echo "<input type='text' name='passport_data' value='" . htmlspecialchars($data['passport_data']) . "'>";
                    echo "<input type='text' name='home_address' value='" . htmlspecialchars($data['home_address']) . "'>";
                    echo "<input type='text' name='phone_number' value='" . htmlspecialchars($data['phone_number']) . "'>";
                    echo "<input type='email' name='email' value='" . htmlspecialchars($data['email']) . "'>";
                    echo "<div>
                        <select name='post_id'>
                            <option value='1'>Фельдшер</option>
                            <option value='2'>Медсестра</option>
                            <option value='3'>Хирург</option>
                            <option value='4'>Ортопед</option>
                        </select>
                        Текущий: ". htmlspecialchars($data['post_name']) ."</div>";
                    echo "<div>
                        <select name='departament_id'>
                            <option value='1'>Хирургическое</option>
                            <option value='2'>Приёмное</option>
                            <option value='3'>Терапевтическое</option>
                            <option value='4'>Кардиологическое</option>
                        </select>
                        Текущий: ". htmlspecialchars($data['dep_name']) ."</div>";
                    echo "<input type='submit' value='Сохранить'>";
                    echo "</form>";
                } else {
                    echo "<p>Сотрудник не найден.</p>";
                }
            }else{
                echo "<p>Некорректный запрос.";
            }
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