<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

// Получаем данные врача для отображения в шапке
$stmt = $pdo->prepare("SELECT full_name FROM врачи WHERE id = ?");
$stmt->execute([$_SESSION['doctor_id']]);
$doctor = $stmt->fetch();

// Получаем текущие записи
$stmt = $pdo->prepare("
    SELECT p.ticket_id, p.visit_date, p.visit_time, 
           pat.full_name, p.purpose 
    FROM Приемы p
    JOIN Пациенты pat ON p.patient_id = pat.medcard_number
    WHERE p.doctor_id = ?
    ORDER BY p.visit_date DESC
");
$stmt->execute([$_SESSION['doctor_id']]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет врача</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Навигационная панель -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Поликлиника</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?= htmlspecialchars($doctor['full_name']) ?></span>
                <a href="logout.php" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Расписание приёмов</h4>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Дата</th>
                                <th>Время</th>
                                <th>Пациент</th>
                                <th>Цель визита</th>
                                <th class="pe-4">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $app): ?>
                                <tr>
                                    <td class="ps-4"><?= date('d.m.Y', strtotime($app['visit_date'])) ?></td>
                                    <td><?= date('H:i', strtotime($app['visit_time'])) ?></td>
                                    <td><?= htmlspecialchars($app['full_name']) ?></td>
                                    <td>
                                        <span class="badge bg-info text-white">
                                            <?= htmlspecialchars($app['purpose']) ?>
                                        </span>
                                    </td>
                                    <td class="pe-4">
                                        <a href="set_diagnosis.php?ticket_id=<?= $app['ticket_id'] ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>Диагноз
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>