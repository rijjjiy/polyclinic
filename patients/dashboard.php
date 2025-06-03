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
$stmt->execute([$user_id]);
$patient = $stmt->fetch();

// Получаем данные о приемах пациента, включая статус
$stmt = $pdo->prepare("
    SELECT p.visit_date, p.cost, p.purpose, p.status, p.ticket_id, v.full_name 
    FROM Приемы p 
    JOIN Врачи v ON p.doctor_id = v.id 
    WHERE p.patient_id = ?
    ORDER BY p.visit_date DESC
");
$stmt->execute([$user_id]);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Личный кабинет</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3"><?= $patient['full_name'] ?></span>
                <a href="logout.php" class="btn btn-outline-light">Выйти</a>
 <a href="booking_step1.php" class="btn btn-success me-2">Записаться на приём</a>
               
		   </div>
	 
        </div>
    </nav>
<!-- Личный кабинет (patients/dashboard.php) -->
<section class="personal-data">
    <h2>Персональные данные</h2>
    <form action="update_profile.php" method="POST">
        <div class="form-group">
            <label>ФИО:</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($patient['full_name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birth_date" value="<?= htmlspecialchars($patient['birth_date']) ?>" readonly>
        </div>
        <div class="form-group">
            <label>Адрес:</label>
            <textarea name="address"><?= htmlspecialchars($patient['address']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Пол:</label>
            <select name="gender">
                <option value="М" <?= $patient['gender'] == 'M' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= $patient['gender'] == 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
        </div>
        <button type="submit" class="btn-save">Сохранить изменения</button>
    </form>
</section>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>



    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Персональные данные</div>
                    <div class="card-body">
                        <p>Мед. карта: <strong><?= $patient['medcard_number'] ?></strong></p>
                        <p>Дата рождения: <?= date('d.m.Y', strtotime($patient['birth_date'])) ?></p>
                        <p>Скидка: <?= $patient['discount'] ?>%</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">История посещений</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Врач</th>
                                    <th>Цель</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
							<!-- В таблице истории -->

                                <?php
                                $stmt = $pdo->prepare("
                                    SELECT p.visit_date, p.cost,p.purpose,p.status,p.ticket_id, v.full_name 
                                    FROM Приемы p 
                                    JOIN Врачи v ON p.doctor_id = v.id 
                                    WHERE patient_id = ?
                                    ORDER BY p.visit_date DESC
                                ");
                                $stmt->execute([$_SESSION['patient_id']]);
                                while ($row = $stmt->fetch()):
                                ?>
                                <tr>
                                    <td><?= date('d.m.Y', strtotime($row['visit_date'])) ?></td>
                                    <td><?= $row['full_name'] ?></td>
                                    <td><?= $row['purpose'] ?? 'Не указана' ?></td>
                                    <td><?= number_format($row['cost'], 2) ?> ₽</td>
									
									<td>
    <?php if ($row['status'] == 'активна'): ?>
        <a 
            href="cancel_appointment.php?ticket_id=<?= $row['ticket_id'] ?>" 
            class="btn btn-danger btn-sm"
        >
            Отменить
        </a>
    <?php else: ?>
        <span class="text-muted">Отменена</span>
    <?php endif; ?>
</td>
									
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>