<?php
session_start();
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Медицинская карта</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <div class="container">
        <h2>История приемов</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Врач</th>
                    <th>Цель посещения</th>
                    <th>Диагноз</th>
                    <th>Стоимость</th>
                    <th>Статус оплаты</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT v.*, d.name as doctor_name, diag.name as diagnosis 
                          FROM visits v 
                          JOIN doctors d ON v.doctor_id = d.id 
                          LEFT JOIN diagnoses diag ON v.diagnosis_id = diag.id 
                          WHERE v.patient_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['patient_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['visit_date']}</td>
                            <td>Др. {$row['doctor_name']}</td>
                            <td>{$row['purpose']}</td>
                            <td>{$row['diagnosis']}</td>
                            <td>{$row['price']} руб.</td>
                            <td>".($row['is_paid'] ? 'Оплачено' : 'Ожидает оплаты')."</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>