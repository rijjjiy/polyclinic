<?php
header('Content-Type: application/json');
require '../includes/config.php';

$doctorId = (int)$_GET['doctor'];
$date = $_GET['date'];

// Стандартные часы работы
$startTime = strtotime('09:00');
$endTime = strtotime('18:00');
$interval = 30 * 60; // 30 минут

$slots = [];
for ($time = $startTime; $time <= $endTime; $time += $interval) {
    $slotTime = date('H:i', $time);
    
    // Проверка занятости слота
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Приемы 
                          WHERE doctor_id = ? 
                          AND visit_date = ? 
                          AND visit_time = ?");
    $stmt->execute([$doctorId, $date, $slotTime]);
    $isBooked = $stmt->fetchColumn();
    
    $slots[] = [
        'time' => $slotTime,
        'status' => $isBooked ? 'занят' : 'свободен'
    ];
}

echo json_encode($slots);