<?php
session_start();
require_once '../includes/config.php';


// Проверка авторизации
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['patient_id'];

// Получение и валидация данных
$full_name = trim($_POST['full_name']);
$address = trim($_POST['address']);
$gender = trim($_POST['gender']);
$email = trim($_POST['email']);

// Проверка email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Некорректный email";
    header("Location: dashboard.php");
    exit();
}

// Обновление данных в БД
try {
    $stmt = $pdo->prepare("
        UPDATE пациенты 
        SET 
            full_name = ?, 
            address = ?, 
            gender = ?, 
            email = ? 
        WHERE medcard_number = ?
    ");
    $stmt->execute([$full_name, $address, $gender, $email, $user_id]);
    
    $_SESSION['success'] = "Данные успешно обновлены!";
} catch (PDOException $e) {
    $_SESSION['error'] = "Ошибка при обновлении данных: " . $e->getMessage();
}

header("Location: dashboard.php");
exit();
?>