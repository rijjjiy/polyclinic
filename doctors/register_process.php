<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['is_admin'])) {
    $data = [
        'full_name' => htmlspecialchars($_POST['full_name']),
        'specialty' => $_POST['specialty'],
        'category' => $_POST['category'],
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];

    try {
        $sql = "INSERT INTO Врачи (full_name, specialty, category, email, password_hash) 
                VALUES (:full_name, :specialty, :category, :email, :password)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        
        $_SESSION['success'] = "Врач успешно зарегистрирован";
        header("Location: register.php");
        exit();
        
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Ошибка регистрации: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>