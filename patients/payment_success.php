<?php
session_start();
require '../includes/config.php';

if (!isset($_GET['payment_id']) || !isset($_SESSION['patient_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Получение информации о платеже
$stmt = $pdo->prepare("
    SELECT p.*, d.full_name AS doctor_name 
    FROM Приемы p
    JOIN Врачи d ON p.doctor_id = d.id
    WHERE p.payment_id = ? 
    AND p.patient_id = ?
");
$stmt->execute([$_GET['payment_id'], $_SESSION['patient_id']]);
$appointment = $stmt->fetch();

if (!$appointment) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оплата успешна</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-success">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Оплата успешно завершена 🎉</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="../assets/img/success.svg" alt="Успех" width="120" class="mb-3">
                            <h5>Спасибо за оплату!</h5>
                        </div>
                        
                        <div class="receipt-details">
                            <h6>Детали платежа:</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Номер платежа:</span>
                                    <span class="text-muted"><?= $appointment['payment_id'] ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Дата приема:</span>
                                    <span><?= date('d.m.Y', strtotime($appointment['visit_date'])) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Сумма:</span>
                                    <span><?= number_format($appointment['cost'], 2) ?> ₽</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="dashboard.php" class="btn btn-primary">
                                Вернуться в личный кабинет
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>