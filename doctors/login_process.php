<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM Врачи WHERE email = ?");
        $stmt->execute([$email]);
        $doctor = $stmt->fetch();

        if ($doctor && password_verify($password, $doctor['password_hash'])) {
            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['full_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Неверные учетные данные";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Ошибка авторизации";
        header("Location: login.php");
        exit();
    }
}
?>