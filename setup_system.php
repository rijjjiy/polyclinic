<?php
require 'includes/config.php';

echo "<h2>Полная настройка системы поликлиники</h2>";

try {
    echo "<h3>1. Обновление паролей всех врачей</h3>";
    
    // Обновляем пароли всех врачей на "password"
    $password_hash = password_hash('password', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE врачи SET password_hash = ?");
    $stmt->execute([$password_hash]);
    echo "<p>✅ Пароли всех врачей обновлены на 'password'</p>";
    
    echo "<h3>2. Создание тестового пациента</h3>";
    
    // Создаем тестового пациента
    $patient_data = [
        'medcard_number' => 999999,
        'full_name' => 'Тестовый Пациент',
        'birth_date' => '1990-01-01',
        'address' => 'г. Москва, ул. Тестовая, 1',
        'gender' => 'М',
        'discount' => 0.00,
        'email' => 'test.patient@mail.com',
        'password_hash' => password_hash('password', PASSWORD_DEFAULT)
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO пациенты (medcard_number, full_name, birth_date, address, gender, discount, email, password_hash) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        full_name = VALUES(full_name),
        birth_date = VALUES(birth_date),
        address = VALUES(address),
        gender = VALUES(gender),
        discount = VALUES(discount),
        email = VALUES(email),
        password_hash = VALUES(password_hash)
    ");
    
    $stmt->execute([
        $patient_data['medcard_number'],
        $patient_data['full_name'],
        $patient_data['birth_date'],
        $patient_data['address'],
        $patient_data['gender'],
        $patient_data['discount'],
        $patient_data['email'],
        $patient_data['password_hash']
    ]);
    
    echo "<p>✅ Тестовый пациент создан/обновлен</p>";
    
    echo "<h3>3. Создание записей на прием</h3>";
    
    // Создаем несколько записей на прием для разных врачей
    $appointments = [
        [
            'doctor_id' => 1, // Семенов Андрей Владимирович (Терапевт)
            'patient_id' => 999999, // Тестовый пациент
            'visit_date' => date('Y-m-d', strtotime('+1 day')),
            'visit_time' => '10:00:00',
            'purpose' => 'консультация',
            'cost' => 1500.00,
            'payment_status' => 'оплачен',
            'status' => 'активна',
            'notes' => 'Первичная консультация'
        ],
        [
            'doctor_id' => 1,
            'patient_id' => 1001, // Иванов Алексей Петрович
            'visit_date' => date('Y-m-d', strtotime('+2 days')),
            'visit_time' => '14:00:00',
            'purpose' => 'обследование',
            'cost' => 2500.00,
            'payment_status' => 'оплачен',
            'status' => 'активна',
            'notes' => 'Плановое обследование'
        ],
        [
            'doctor_id' => 2, // Захарова Ирина Станиславовна (Хирург)
            'patient_id' => 1002, // Петрова Мария Сергеевна
            'visit_date' => date('Y-m-d', strtotime('+3 days')),
            'visit_time' => '11:00:00',
            'purpose' => 'лечение',
            'cost' => 5000.00,
            'payment_status' => 'оплачен',
            'status' => 'активна',
            'notes' => 'Консультация хирурга'
        ],
        [
            'doctor_id' => 5, // Григорьев Денис Олегович (Кардиолог)
            'patient_id' => 1005, // Смирнов Артем Александрович
            'visit_date' => date('Y-m-d', strtotime('+1 day')),
            'visit_time' => '16:00:00',
            'purpose' => 'консультация',
            'cost' => 2000.00,
            'payment_status' => 'оплачен',
            'status' => 'активна',
            'notes' => 'Консультация кардиолога'
        ],
        [
            'doctor_id' => 3, // Козлов Михаил Александрович (Офтальмолог)
            'patient_id' => 1003, // Сидоров Дмитрий Игоревич
            'visit_date' => date('Y-m-d', strtotime('+4 days')),
            'visit_time' => '09:30:00',
            'purpose' => 'обследование',
            'cost' => 3000.00,
            'payment_status' => 'ожидает',
            'status' => 'активна',
            'notes' => 'Проверка зрения'
        ],
        [
            'doctor_id' => 4, // Павлова Екатерина Сергеевна (Невролог)
            'patient_id' => 1004, // Кузнецова Елена Викторовна
            'visit_date' => date('Y-m-d', strtotime('+5 days')),
            'visit_time' => '13:00:00',
            'purpose' => 'лечение',
            'cost' => 4000.00,
            'payment_status' => 'ожидает',
            'status' => 'активна',
            'notes' => 'Неврологическое обследование'
        ]
    ];
    
    foreach ($appointments as $app) {
        $stmt = $pdo->prepare("
            INSERT INTO приемы (doctor_id, patient_id, visit_date, purpose, cost, payment_status, visit_time, status, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $app['doctor_id'],
            $app['patient_id'],
            $app['visit_date'],
            $app['purpose'],
            $app['cost'],
            $app['payment_status'],
            $app['visit_time'],
            $app['status'],
            $app['notes']
        ]);
    }
    
    echo "<p>✅ Создано " . count($appointments) . " записей на прием</p>";
    
    echo "<h3>4. Создание рабочего расписания врачей</h3>";
    
    // Создаем рабочее расписание для врачей
    $schedule_slots = [];
    $doctors = [1, 2, 3, 4, 5]; // Основные врачи
    
    for ($day = 0; $day < 7; $day++) {
        $date = date('Y-m-d', strtotime("+$day days"));
        
        foreach ($doctors as $doctor_id) {
            // Создаем слоты с 9:00 до 17:00
            for ($hour = 9; $hour < 17; $hour++) {
                $start_time = sprintf('%02d:00:00', $hour);
                $end_time = sprintf('%02d:00:00', $hour + 1);
                
                $schedule_slots[] = [
                    'doctor_id' => $doctor_id,
                    'date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'is_available' => 1
                ];
            }
        }
    }
    
    foreach ($schedule_slots as $slot) {
        $stmt = $pdo->prepare("
            INSERT INTO doctor_schedule (doctor_id, date, start_time, end_time, is_available) 
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            start_time = VALUES(start_time),
            end_time = VALUES(end_time),
            is_available = VALUES(is_available)
        ");
        
        $stmt->execute([
            $slot['doctor_id'],
            $slot['date'],
            $slot['start_time'],
            $slot['end_time'],
            $slot['is_available']
        ]);
    }
    
    echo "<p>✅ Создано рабочее расписание для врачей</p>";
    
    echo "<h3>5. Информация для входа</h3>";
    
    echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>Данные для входа:</h4>";
    
    echo "<h5>Врачи (пароль: password):</h5>";
    $stmt = $pdo->query("SELECT id, full_name, email, specialty FROM врачи ORDER BY id");
    $doctors = $stmt->fetchAll();
    
    echo "<ul>";
    foreach ($doctors as $doctor) {
        echo "<li><strong>{$doctor['full_name']}</strong> ({$doctor['specialty']}) - {$doctor['email']}</li>";
    }
    echo "</ul>";
    
    echo "<h5>Пациенты (пароль: password):</h5>";
    echo "<ul>";
    echo "<li><strong>Тестовый Пациент</strong> - test.patient@mail.com</li>";
    echo "<li><strong>Иванов Алексей Петрович</strong> - ivanov@mail.com</li>";
    echo "<li><strong>Петрова Мария Сергеевна</strong> - petrova@mail.com</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h3>6. Ссылки для тестирования</h3>";
    
    echo "<div style='background: #e9ecef; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>Основные страницы:</h4>";
    echo "<ul>";
    echo "<li><a href='index.html' target='_blank'>Главная страница</a></li>";
    echo "<li><a href='doctors/login.php' target='_blank'>Вход для врачей</a></li>";
    echo "<li><a href='patients/login.php' target='_blank'>Вход для пациентов</a></li>";
    echo "</ul>";
    
    echo "<h4>Рекомендуемый порядок тестирования:</h4>";
    echo "<ol>";
    echo "<li>Войди как врач (semenov@clinic.ru / password)</li>";
    echo "<li>Проверь расписание, статистику, установку диагноза</li>";
    echo "<li>Войди как пациент (test.patient@mail.com / password)</li>";
    echo "<li>Запишись на прием к врачу</li>";
    echo "<li>Оплати прием</li>";
    echo "<li>Проверь историю посещений</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<h3>✅ Система полностью настроена и готова к тестированию!</h3>";
    
} catch (PDOException $e) {
    echo "<p>❌ Ошибка: " . $e->getMessage() . "</p>";
}
?> 