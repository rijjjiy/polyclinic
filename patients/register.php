<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация пациента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="bg-light">
  
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Регистрация пациента</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="register_process.php" method="post" novalidate>
                            <!-- ФИО -->
                            <div class="mb-4">
                                <label for="full_name" class="form-label fw-bold">ФИО</label>
                                <input type="text" 
                                       name="full_name" 
                                       class="form-control form-control-lg"
                                       placeholder="Иванов Иван Иванович"
                                       required
                                       autofocus>
                            </div>

                            <!-- Дата рождения -->
                            <div class="mb-4">
                                <label for="birth_date" class="form-label fw-bold">Дата рождения</label>
                                <input type="date" 
                                       name="birth_date" 
                                       class="form-control form-control-lg"
                                       max="<?= date('Y-m-d') ?>"
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Электронная почта</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control form-control-lg"
                                       placeholder="example@mail.ru"
                                       required>
                                <div class="form-text">На этот email будут приходить уведомления</div>
                            </div>

                            <!-- Пароль -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Пароль</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control form-control-lg"
                                       minlength="6"
                                       required>
                                <div class="form-text">Минимум 6 символов</div>
                            </div>

                            <!-- Подтверждение пароля -->
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label fw-bold">Подтвердите пароль</label>
                                <input type="password" 
                                       name="confirm_password" 
                                       class="form-control form-control-lg"
                                       minlength="6"
                                       required>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Зарегистрироваться
                                </button>
                                <a href="login.php" class="btn btn-link text-decoration-none">
                                    Уже есть аккаунт? Войдите
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    
    <!-- Подключение Bootstrap JS и иконок -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</body>
</html>