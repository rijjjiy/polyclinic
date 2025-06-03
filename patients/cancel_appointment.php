<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['patient_id']) || !isset($_GET['ticket_id'])) {
    header("Location: login.php");
    exit();
}

$ticket_id = (int)$_GET['ticket_id'];

try {
    // Обновляем статус приёма
    $stmt = $pdo->prepare("
        UPDATE Приемы 
        SET status = 'отменена' 
        WHERE ticket_id = ? 
        AND patient_id = ?
    ");
    $stmt->execute([$ticket_id, $_SESSION['patient_id']]);

    // Освобождаем временной слот
    $stmt = $pdo->prepare("
        UPDATE doctor_schedule 
        SET is_available = TRUE 
        WHERE slot_id = (
            SELECT slot_id FROM Приемы 
            WHERE ticket_id = ?
        )
    ");
    $stmt->execute([$ticket_id]);

    $_SESSION['success'] = "Запись успешно отменена!";
} catch (PDOException $e) {
    $_SESSION['error'] = "Ошибка: " . $e->getMessage();
}

header("Location: dashboard.php");
exit();
?>