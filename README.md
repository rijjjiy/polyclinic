# 🏥 Система поликлиники

Веб-приложение для управления записями пациентов к врачам.

## 🚀 Быстрый запуск

### 1. Запуск XAMPP
- Откройте XAMPP Control Panel
- Запустите Apache и MySQL
- Убедитесь, что оба сервиса работают (зеленые индикаторы)

### 2. Импорт базы данных
- Откройте `http://localhost/phpmyadmin`
- Создайте базу данных `polyclinic`
- Импортируйте файл `polyclinic.sql`

### 3. Настройка системы
- Откройте `http://localhost/polyclinic/setup_system.php`
- Дождитесь сообщения "Система готова к работе!"

### 4. Тестирование
После настройки доступны тестовые аккаунты:

**Врачи:**
- semenov@clinic.ru / password
- zakharova@clinic.ru / password
- kozlov@clinic.ru / password
- pavlova@clinic.ru / password
- grigoriev@clinic.ru / password

**Пациенты:**
- ivanov@mail.com / password
- petrova@mail.com / password
- sidorov@mail.com / password
- kuznetsova@mail.com / password
- smirnov@mail.com / password

## 📁 Структура проекта

```
polyclinic/
├── index.html              # Главная страница
├── setup_system.php        # Настройка системы
├── polyclinic.sql          # База данных
├── includes/
│   └── config.php          # Настройки БД
├── doctors/                # Файлы для врачей
├── patients/               # Файлы для пациентов
├── admin/                  # Административная панель
├── api/                    # API endpoints
└── assets/                 # CSS, JS, изображения
```

## 🔗 Ссылки для тестирования

- **Главная страница:** `http://localhost/polyclinic/`
- **Вход для врачей:** `http://localhost/polyclinic/doctors/login.php`
- **Вход для пациентов:** `http://localhost/polyclinic/patients/login.php`

## ⚠️ Возможные проблемы

### Ошибка подключения к БД
- Убедитесь, что MySQL запущен
- Проверьте файл `includes/config.php`

### Страница не загружается
- Убедитесь, что Apache запущен
- Проверьте, что файлы в папке `htdocs/polyclinic/`

### Ошибки при импорте
- Убедитесь, что файл `polyclinic.sql` не поврежден
- Попробуйте импортировать заново 