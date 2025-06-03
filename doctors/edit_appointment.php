<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['doctor_id']) || !isset($_GET['ticket_id'])) {
    header("Location: login.php");
    exit();
}

$ticket_id = (int)$_GET['ticket_id'];

// Получаем данные приёма
$stmt = $pdo->prepare("
    SELECT * FROM Приемы 
    WHERE ticket_id = ?
");
$stmt->execute([$ticket_id]);
$appointment = $stmt->fetch();

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diagnosis = $_POST['diagnosis'];
    $purpose = $_POST['purpose'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("
        UPDATE Приемы 
        SET diagnosis_code = ?, purpose = ?, notes = ? 
        WHERE ticket_id = ?
    ");
    $stmt->execute([$diagnosis, $purpose, $notes, $ticket_id]);

    $_SESSION['success'] = "Данные обновлены!";
    header("Location: dashboard.php");
    exit();
}
?>

<!-- HTML-форма с полями диагноза, цели и заметок -->