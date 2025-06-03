<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['patient_id'];
// Получаем данные пациента
$stmt = $pdo->prepare("SELECT * FROM Пациенты WHERE medcard_number = ?");
$stmt->execute([$_SESSION['patient_id']]);
$patient = $stmt->fetch();
// Получаем список врачей
$stmt = $pdo->query("SELECT id, full_name, specialty FROM врачи");
$doctors = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
</head>
<body>
    <!-- Навигация как в dashboard.php -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Личный кабинет</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?= $patient['full_name'] ?></span>
				
                <a href="../index.html" class="btn btn-outline-light">Выйти</a>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <div class="booking-container">
        <div class="container">
            <h2 class="doctor-selection-header">Выберите специалиста</h2>
            
            <div class="doctor-list">
                <?php foreach ($doctors as $doctor): ?>
                    <div class="doctor-card">
                        <h3><?= htmlspecialchars($doctor['full_name']) ?></h3>
                        <p class="doctor-specialty"><?= htmlspecialchars($doctor['specialty']) ?></p>
                        <a 
                            href="booking_step2.php?doctor_id=<?= $doctor['id'] ?>" 
                            class="btn-book"
                        >
                            <i class="fas fa-calendar-alt me-2"></i>Выбрать время
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Подключение иконок Font Awesome -->
    <script src="https://kit.fontawesome.com/ваш-код.js" crossorigin="anonymous"></script>
</body>
</html>