<?php
include_once 'utils.php';

class Patient {
    function showAll(): array{
        $conn = conn();
        $sql = "SELECT
                    p.id,
                    p.fio, 
                    p.passport_data, 
                    p.birth_date, 
                    p.home_address, 
                    p.phone_number, 
                    p.email, 
                    a.id AS appointment_id
                FROM 
                    patients p
                LEFT JOIN 
                    appointments a ON p.id = a.fk_patient
                ORDER BY 
                    p.id DESC";

        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (empty($data)) {
            return [];
        }else{
            return $data;
        }
    }
    
    function showOne(int $id): array {
        $conn = conn();
        $sql = "SELECT 
                    p.fio, 
                    p.passport_data, 
                    p.birth_date, 
                    p.home_address, 
                    p.phone_number, 
                    p.email, 
                    a.id AS appointment_id
                FROM 
                    patients p
                LEFT JOIN 
                    appointments a ON p.id = a.fk_patient
                WHERE 
                    p.id = $id";
        
        $result = mysqli_query($conn,$sql);
        $data = mysqli_fetch_assoc($result);

        if (empty($data)) {
            return [];
        }else{
            return $data;
        }
    }

    function add(string $data): string {
        /*$data = json_decode($data, true);
        $conn = conn();

        $dataArray = [
            "fio" => $data['fio'],
            "passport_data" => $data['passport_data'],
            "home_address" => $data['home_address'],
            "phone_number" => $data['phone_number'],
            "email" => $data['email']
        ];

        $invalidKeys = [];
        foreach ($dataArray as $key => $value) {
            if (empty($value)) {
                $invalidKeys[$key] = "$key is empty";
            }
        }

        if (!empty($invalidKeys)) {
            return jsonMessage(400, ['message' => 'Some fields are empty', 'data' => $invalidKeys]);
        }

        $sql = "INSERT INTO patients (fio, passport_data, home_address, phone_number, email) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssss', $data['fio'], $data['passport_data'], $data['home_address'], $data['phone_number'], $data['email']);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            return jsonMessage(200, ['message' => 'Successfully added patient']);
        }
        return jsonMessage(400, ['message' => 'Error adding patient']);
        */
    }

    function edit(int $id, array $data): bool {
        $fio = $data['fio'] ?? null;
        $passportData = $data['passport_data'] ?? null;
        $birthDate = $data['birth_date'] ?? null;
        $homeAddress = $data['home_address'] ?? null;
        $phoneNumber = $data['phone_number'] ?? null;
        $email = $data['email'] ?? null;

        $conn = conn();
        $sql = "UPDATE `patients` SET `fio` = ?,
        `passport_data` = ?,`birth_date` = ?,
        `home_address` = ?,`phone_number` = ?,
        `email` = ? WHERE `id` = ?";

        $stmt = mysqli_prepare($conn, $sql);
        $bindParams = mysqli_stmt_bind_param($stmt, "ssssssi", $fio, $passportData, $birthDate, $homeAddress, $phoneNumber, $email, $id);
        if($stmt !== false && $bindParams !== false){
            return mysqli_stmt_execute($stmt);
        }else{
            return false;
        }
    }

    function delete(int $id): string {
        $conn = conn();
        $sql = "DELETE FROM patients WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            return jsonMessage(200, ['success' => true, 'message' => 'Successfully deleted patient']);
        }
        return jsonMessage(400, ['success' => false, 'message' => 'Error deleting patient']);
    }
}