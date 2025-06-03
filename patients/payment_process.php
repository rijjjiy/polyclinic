<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['patient_id'])) {
    $appointmentId = (int)$_POST['appointment_id'];
    
    try {
        // Генерация уникального ID платежа
        $paymentId = bin2hex(random_bytes(16));
        
        // Обновление записи в базе данных
        $stmt = $pdo->prepare("
            UPDATE Приемы 
            SET payment_status = 'оплачен', 
                payment_id = ? 
            WHERE ticket_id = ? 
            AND patient_id = ?
        ");
        
        $stmt->execute([
            $paymentId,
            $appointmentId,
            $_SESSION['patient_id']
        ]);
        
        // Перенаправление на страницу успеха
        header("Location: payment_success.php?payment_id=" . $paymentId);
        exit();
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Ошибка оплаты. Пожалуйста, попробуйте позже.";
        header("Location: payment.php?appointment=" . $appointmentId);
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>