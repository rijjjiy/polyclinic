<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'doctor_id' => (int)$_POST['doctor_id'],
        'patient_id' => $_SESSION['patient_id'],
        'visit_date' => $_POST['visit_date'],
        'visit_time' => $_POST['visit_time'],
        'purpose' => 'консультация',
        'status' => 'занят'
    ];

    // Расчет стоимости
    $stmt = $pdo->prepare("SELECT category FROM Врачи WHERE id = ?");
    $stmt->execute([$data['doctor_id']]);
    $category = $stmt->fetchColumn();
    
    $basePrice = [
        'высшая' => 2500,
        'первая' => 1800,
        'вторая' => 1200
    ][$category] ?? 1000;

    $data['cost'] = $basePrice * (1 - ($_SESSION['discount'] / 100));

    // Создание записи
    $sql = "INSERT INTO Приемы (doctor_id, patient_id, visit_date, visit_time, purpose, cost, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $pdo->prepare($sql)->execute(array_values($data));
    
    header("Location: payment.php?appointment=".$pdo->lastInsertId());
    exit();
}