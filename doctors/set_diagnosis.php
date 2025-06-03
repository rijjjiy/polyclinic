<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['doctor_id']) || !isset($_GET['ticket_id'])) {
    header("Location: login.php");
    exit();
}

// Получаем данные приема
$stmt = $pdo->prepare("
    SELECT * FROM Приемы 
    WHERE ticket_id = ?
");
$stmt->execute([$_GET['ticket_id']]);
$appointment = $stmt->fetch();

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diagnosis = $_POST['diagnosis'];
    $purpose = $_POST['purpose'];
    
    $stmt = $pdo->prepare("
        UPDATE Приемы 
        SET diagnosis_code = ?, purpose = ? 
        WHERE ticket_id = ?
    ");
    $stmt->execute([$diagnosis, $purpose, $_GET['ticket_id']]);
    
    $_SESSION['success'] = "Диагноз успешно сохранен!";
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/main.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Установка диагноза</h2>
        <form method="POST">
            <div class="form-group">
                <label>Код диагноза:</label>
                <input type="text" name="diagnosis" required>
            </div>
            <div class="form-group">
                <label>Цель визита:</label>
                <select name="purpose">
                    <option value="Консультация">Консультация</option>
                    <option value="Обследование">Обследование</option>
                    <option value="Лечение">Лечение</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Сохранить</button>
        </form>
    </div>
</body>
</html>