<?php
session_start();
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 403 Forbidden");
    exit("Доступ запрещен");
}

// Инициализация ошибок
$_SESSION['errors'] = [];

// Обработка данных формы
$data = [
    'full_name' => trim($_POST['full_name'] ?? ''),
    'birth_date' => $_POST['birth_date'] ?? '',
    'email' => trim($_POST['email'] ?? ''),
    'password' => $_POST['password'] ?? '',
    'confirm_password' => $_POST['confirm_password'] ?? ''
];

// Валидация полей
if (empty($data['full_name'])) {
    $_SESSION['errors']['full_name'] = "Укажите ФИО";
}

if (empty($data['birth_date']) || !strtotime($data['birth_date'])) {
    $_SESSION['errors']['birth_date'] = "Некорректная дата рождения";
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errors']['email'] = "Некорректный email";
}

if (strlen($data['password']) < 6) {
    $_SESSION['errors']['password'] = "Пароль должен содержать минимум 6 символов";
}

if ($data['password'] !== $data['confirm_password']) {
    $_SESSION['errors']['confirm_password'] = "Пароли не совпадают";
}

// Если есть ошибки - возвращаем на форму
if (!empty($_SESSION['errors'])) {
    $_SESSION['old'] = $data;
    header("Location: register.php");
    exit();
}

try {
    // Проверка уникальности email
    $checkEmail = $pdo->prepare("SELECT medcard_number FROM Пациенты WHERE email = ?");
    $checkEmail->execute([$data['email']]);
    
    if ($checkEmail->rowCount() > 0) {
        $_SESSION['errors']['email'] = "Этот email уже зарегистрирован";
        $_SESSION['old'] = $data;
        header("Location: register.php");
        exit();
    }

    // Генерация уникального номера карты
    do {
        $medcard_number = mt_rand(100000, 999999);
        $checkCard = $pdo->prepare("SELECT medcard_number FROM Пациенты WHERE medcard_number = ?");
        $checkCard->execute([$medcard_number]);
    } while ($checkCard->rowCount() > 0);

    // Подготовка данных для вставки
    $insertData = [
        'medcard_number' => $medcard_number,
        'full_name' => htmlspecialchars($data['full_name']),
        'birth_date' => date('Y-m-d', strtotime($data['birth_date'])),
        'email' => $data['email'],
        'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
        'discount' => 0,
        'address' => 'Не указан', // Можно добавить поле в форму
        'gender' => 'Не указан'   // Можно добавить поле в форму
    ];

    // SQL-запрос
    $sql = "INSERT INTO Пациенты (
        medcard_number, 
        full_name, 
        birth_date, 
        address, 
        gender, 
        email, 
        password_hash, 
        discount
    ) VALUES (
        :medcard_number,
        :full_name,
        :birth_date,
        :address,
        :gender,
        :email,
        :password_hash,
        :discount
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($insertData);

    // Установка сессии
    $_SESSION['patient_id'] = $medcard_number;
    $_SESSION['success'] = "Регистрация прошла успешно!";
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    error_log("Ошибка регистрации: " . $e->getMessage());
    $_SESSION['error'] = "Ошибка регистрации. Пожалуйста, попробуйте позже.";
    header("Location: register.php");
    exit();
}
?>