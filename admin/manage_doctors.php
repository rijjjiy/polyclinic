<?php
session_start();
require '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// CRUD операции
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка добавления/редактирования
}

// Получение списка врачей
$doctors = $pdo->query("SELECT * FROM Врачи")->fetchAll();
?>

<!-- Аналогичная структура как в dashboard.php -->
<div class="admin-main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Управление врачами</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
            <i class="bi bi-plus-lg"></i> Добавить врача
        </button>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Специальность</th>
                        <th>Категория</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?= $doctor['full_name'] ?></td>
                        <td><?= $doctor['specialty'] ?></td>
                        <td><?= $doctor['category'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editDoctorModal"
                                    data-id="<?= $doctor['id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete(<?= $doctor['id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Модальное окно добавления -->
<div class="modal fade" id="addDoctorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="manage_doctors.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить врача</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Поля формы -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Вы уверены, что хотите удалить врача?')) {
        window.location = `delete_doctor.php?id=${id}`;
    }
}
</script>