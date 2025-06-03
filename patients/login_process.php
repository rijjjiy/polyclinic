<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM Пациенты WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['patient_id'] = $user['medcard_number'];
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