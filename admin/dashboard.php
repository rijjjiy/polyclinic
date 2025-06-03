<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Статистика
$stats = [
    'patients' => $pdo->query("SELECT COUNT(*) FROM Пациенты")->fetchColumn(),
    'doctors' => $pdo->query("SELECT COUNT(*) FROM Врачи")->fetchColumn(),
    'appointments' => $pdo->query("SELECT COUNT(*) FROM Приемы")->fetchColumn(),
    'revenue' => $pdo->query("SELECT SUM(cost) FROM Приемы")->fetchColumn()
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .admin-sidebar {
            background: #2c3e50;
            min-height: 100vh;
            color: white;
            width: 280px;
            position: fixed;
        }
        .admin-main {
            margin-left: 280px;
            padding: 20px;
            background: #f8f9fa;
            min-height: 100vh;
        }
        .stat-card {
            transition: transform 0.3s;
            border: none;
            border-radius: 15px;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="admin-sidebar p-3">
        <h3 class="mb-4">Панель управления</h3>
        <nav class="nav flex-column">
            <a class="nav-link text-white active" href="dashboard.php">
                <i class="bi bi-speedometer2 me-2"></i> Дашборд
            </a>
            <a class="nav-link text-white" href="manage_doctors.php">
                <i class="bi bi-person-badge me-2"></i> Управление врачами
            </a>
            <a class="nav-link text-white" href="manage_patients.php">
                <i class="bi bi-people me-2"></i> Управление пациентами
            </a>
            <a class="nav-link text-white" href="appointments.php">
                <i class="bi bi-calendar-event me-2"></i> Приемы
            </a>
            <a class="nav-link text-white" href="diagnoses.php">
                <i class="bi bi-clipboard-pulse me-2"></i> Диагнозы
            </a>
            <a class="nav-link text-white" href="reports.php">
                <i class="bi bi-bar-chart-line me-2"></i> Отчеты
            </a>
            <a class="nav-link text-white" href="logout.php">
                <i class="bi bi-box-arrow-left me-2"></i> Выход
            </a>
        </nav>
    </div>

    <div class="admin-main">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Добро пожаловать, <?= $_SESSION['admin_name'] ?></h2>
            <div class="text-muted"><?= date('d.m.Y H:i') ?></div>
        </div>

        <!-- Статистика -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-people me-2"></i>Пациенты</h5>
                        <h2><?= $stats['patients'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-person-badge me-2"></i>Врачи</h5>
                        <h2><?= $stats['doctors'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-calendar-check me-2"></i>Приемы</h5>
                        <h2><?= $stats['appointments'] ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body">
                        <h5><i class="bi bi-cash-coin me-2"></i>Выручка</h5>
                        <h2><?= number_format($stats['revenue'], 2) ?> ₽</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Графики -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Активность по дням</h5>
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Распределение по специальностям</h5>
                        <canvas id="specialtiesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // График активности
        const ctx1 = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: <?php 
                    $dates = $pdo->query("SELECT DATE(visit_date) AS day, COUNT(*) 
                        FROM Приемы 
                        GROUP BY day 
                        ORDER BY day DESC 
                        LIMIT 7")->fetchAll(PDO::FETCH_COLUMN);
                    echo json_encode(array_reverse($dates));
                ?>,
                datasets: [{
                    label: 'Количество приемов',
                    data: <?php 
                        $counts = $pdo->query("SELECT COUNT(*) 
                            FROM Приемы 
                            GROUP BY DATE(visit_date) 
                            ORDER BY DATE(visit_date) DESC 
                            LIMIT 7")->fetchAll(PDO::FETCH_COLUMN);
                        echo json_encode(array_reverse($counts));
                    ?>,
                    borderColor: '#2c3e50',
                    tension: 0.3
                }]
            }
        });

        // Круговая диаграмма специальностей
        const ctx2 = document.getElementById('specialtiesChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php 
                    $specs = $pdo->query("SELECT specialty, COUNT(*) 
                        FROM Врачи 
                        GROUP BY specialty")->fetchAll(PDO::FETCH_COLUMN);
                    echo json_encode($specs);
                ?>,
                datasets: [{
                    data: <?php 
                        $counts = $pdo->query("SELECT COUNT(*) 
                            FROM Врачи 
                            GROUP BY specialty")->fetchAll(PDO::FETCH_COLUMN);
                        echo json_encode($counts);
                    ?>,
                    backgroundColor: [
                        '#2c3e50', '#3498db', '#e74c3c', '#2ecc71', '#9b59b6'
                    ]
                }]
            }
        });
    </script>
</body>
</html>