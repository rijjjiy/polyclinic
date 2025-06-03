<?php
session_start();
if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Статистика</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <div class="container">
        <h2>Статистика приемов</h2>
        
        <div class="chart-container">
            <canvas id="patientsChart"></canvas>
        </div>

        <?php
        $query = "SELECT DATE(visit_date) as date, COUNT(*) as count 
                  FROM visits 
                  WHERE doctor_id = ? 
                  GROUP BY DATE(visit_date) 
                  ORDER BY date DESC LIMIT 7";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION['doctor_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $labels = [];
        $data = [];
        while ($row = $result->fetch_assoc()) {
            array_unshift($labels, $row['date']);
            array_unshift($data, $row['count']);
        }
        ?>
        
        <script>
            const ctx = document.getElementById('patientsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Количество пациентов',
                        data: <?= json_encode($data) ?>,
                        borderColor: '#4CAF50',
                        tension: 0.1
                    }]
                }
            });
        </script>
    </div>
</body>
</html>