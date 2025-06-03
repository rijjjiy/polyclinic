<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM Администраторы WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
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