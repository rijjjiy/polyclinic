<?php
session_start();
require '../includes/config.php';

// Проверка, что пользователь - администратор
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить врача</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Добавить нового врача</h4>
                    </div>
                    <div class="card-body">
                        <form action="register_process.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">ФИО врача</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Специальность</label>
                                    <select name="specialty" class="form-select" required>
                                        <option value="терапевт">Терапевт</option>
                                        <option value="хирург">Хирург</option>
                                        <option value="кардиолог">Кардиолог</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Категория</label>
                                    <select name="category" class="form-select" required>
                                        <option value="высшая">Высшая</option>
                                        <option value="первая">Первая</option>
                                        <option value="вторая">Вторая</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Пароль</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100">Добавить врача</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>