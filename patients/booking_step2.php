<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['patient_id']) || !isset($_GET['doctor_id'])) {
    header("Location: booking_step1.php");
    exit();
}
$user_id = $_SESSION['patient_id'];
// Получаем данные пациента
$stmt = $pdo->prepare("SELECT * FROM Пациенты WHERE medcard_number = ?");
$stmt->execute([$_SESSION['patient_id']]);
$patient = $stmt->fetch();
$doctor_id = $_GET['doctor_id'];
// Получаем доступные слоты
$stmt = $pdo->prepare("
    SELECT * FROM doctor_schedule 
    WHERE doctor_id = ? 
    AND date >= CURDATE() 
    AND is_available = TRUE
");
$stmt->execute([$doctor_id]);
$slots = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
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

    <div class="container">
        <h2>Выберите время</h2>
        <div class="time-slots">
            <?php foreach ($slots as $slot): ?>
                <div class="slot-card">
                    <p><?= date('d.m.Y', strtotime($slot['date'])) ?></p>
                    <p><?= date('H:i', strtotime($slot['start_time'])) ?> - <?= date('H:i', strtotime($slot['end_time'])) ?></p>
                    <a href="booking_confirm.php?slot_id=<?= $slot['slot_id'] ?>" class="btn-book">Записаться</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>