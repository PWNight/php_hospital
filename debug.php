<?php
echo "Проверка вывода таблицы пациентов: " . checkSelectPatients() . "<br><br>";
echo "Проверка вывода таблицы сотрудников: " . checkSelectEmployers() . "<br><br>";
echo "Проверка положительного сценария обновления пациента: " . checkUpdatePatient(). "<br><br>";
echo "Проверка положительного сценария обновления сотрудника: " . checkUpdateEmployer(). "<br><br>";
echo "Проверка негативного сценария обновления пациента: " . checkInvalidUpdatePatients(). "<br><br>";
echo "Проверка негативного сценария обновления сотрудника: " . checkInvalidUpdateEmployers(). "<br><br>";

function checkSelectPatients() {
    $html = @file_get_contents("http://localhost/php_hospital/show.php?table=patients");
    if ($html === false) {
        return "Ошибка валидации таблицы: возвращён пустой html";
    }

    $dom = new DOMDocument;
    @$dom->loadHTML($html);

    $rows = $dom->getElementsByTagName('tr');

    $isTableFilled = true;
    foreach ($rows as $row) {
        $cells = $row->getElementsByTagName('td');

        if ($cells->length > 0) {
            foreach ($cells as $cell) {
                if (trim($cell->textContent) === '') {
                    $isTableFilled = false; 
                    break 2;
                }
            }
        }
    }

    return $isTableFilled ? "Проверка выполнена." : "Ошибка валидации: найдены пустые ячейки";
}

function checkSelectEmployers() {
    $html = @file_get_contents("http://localhost/php_hospital/show.php?table=employers");
    if ($html === false) {
        return "Ошибка валидации: возвращён пустой html";
    }

    $dom = new DOMDocument;
    @$dom->loadHTML($html);

    $rows = $dom->getElementsByTagName('tr');

    $isTableFilled = true;
    foreach ($rows as $row) {
        $cells = $row->getElementsByTagName('td');

        if ($cells->length > 0) {
            foreach ($cells as $cell) {
                if (trim($cell->textContent) === '') {
                    $isTableFilled = false; 
                    break 2;
                }
            }
        }
    }

    return $isTableFilled ? "Проверка выполнена." : "Ошибка валидации: найдены пустые ячейки";
}
function checkUpdatePatient() {
    include_once "utils/patient.php";
    $patient = new Patient();
    try {
        $data = $patient->showOne(1);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции showOne() в классе Patient";
    }

    //get patient email and replace it to test email
    $patientEmail = $data['email'];
    $newPatientEmail = "test@test.com";
    $data['email'] = $newPatientEmail;

    //edit patient email in db and check result
    try {
        $result = $patient->edit(1,$data);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции edit() в классе Patient при попытке заменить почту на тестовую";
    }

    //edit patient email to old in db and check result
    $data['email'] = $patientEmail;
    try {
        $result = $patient->edit(1,$data);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции edit() в классе Patient при попытке заменить почту на тестовую";
    }

    return "Проверка выполнена.";

}
function checkInvalidUpdatePatients() {
    include_once "utils/patient.php";
    $patient = new Patient();
    try {
        $data = $patient->showOne(1);
    }   catch (Error $e) {
        return "Проверка выполнена: Ошибка валидации: внутренная ошибка функции showOne() в классе Patient";
    }

    //get patient email and replace it to test email
    $patientEmail = $data['email'];
    $newPatientEmail = "test@test.com";
    $data['email'] = $newPatientEmail;

    //edit patient email in db and check result
    try {
        $result = $patient->edit(1,$data);
    }   catch (Error $e) {
        return "Проверка выполнена:  Ошибка валидации: внутренная ошибка функции edit() в классе Patient при попытке заменить почту на тестовую";
    }

    //edit patient email to old in db and check result
    $data['email'] = $patientEmail;
    try {
        $result = $patient->edit(1,$data);
    }   catch (Error $e) {
        return "Проверка выполнена:  Ошибка валидации: внутренная ошибка функции edit() в классе Patient при попытке заменить почту на тестовую";
    }

    return "Проверка не выполнена: операция успешно выполнена.";
}
function checkUpdateEmployer() {
    include_once "utils/employer.php";
    $employer = new Employer();
    try {
        $data = $employer->showOne(1);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции showOne() в классе Employer";
    }
    //get employer email and replace it to test email
    $employerEmail = $data['email'];
    $newEmployerEmail = "test@test.com";
    $data['email'] = $newEmployerEmail;

    //edit employer email in db and check result
    try {
        $result = $employer->edit(1,$data);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции edit() в классе Employer при попытке заменить почту на тестовую";
    }

    //edit employer email to old in db and check result
    $data['email'] = $employerEmail;
    try {
        $result = $employer->edit(1,$data);
    }   catch (Error $e) {
        return "Ошибка валидации: внутренная ошибка функции edit() в классе Employer при попытке заменить почту на тестовую";
    }

    return "Проверка выполнена.";

}
function checkInvalidUpdateEmployers() {
    include_once "utils/employer.php";  
    $employer = new Employer();
    try {
        $data = $employer->showOne(15555);
    }   catch (Error $e) {
        return "Проверка выполнена: Ошибка валидации: внутренная ошибка функции showOne() в классе Employer";
    }

    //get employer email and replace it to test email
    $employerEmail = $data['email'];
    $newEmployerEmail = "test@test.com";
    $data['email'] = $newEmployerEmail;

    //edit employer email in db and check result
    try {
        $result = $employer->edit(1555555,$data);
    }   catch (Error $e) {
        return "Проверка выполнена:  Ошибка валидации: внутренная ошибка функции edit() в классе Employer при попытке заменить почту на тестовую";
    }

    //edit employer email to old in db and check result
    $data['email'] = $employerEmail;
    try {
        $result = $employer->edit(155555,$data);
    }   catch (Error $e) {
        return "Проверка выполнена:  Ошибка валидации: внутренная ошибка функции edit() в классе Employer при попытке заменить почту на тестовую";
    }

    return "Проверка не выполнена: операция успешно выполнена.";
}
?>