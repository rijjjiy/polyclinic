-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `polyclinic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `slot_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`slot_id`, `doctor_id`, `date`, `start_time`, `end_time`, `is_available`) VALUES
(1, 1, '2025-01-31', '09:00:00', '10:00:00', 1),
(2, 1, '2025-01-31', '10:30:00', '11:30:00', 1),
(3, 2, '2025-02-01', '14:00:00', '15:00:00', 1),
(4, 1, '2025-01-31', '09:00:00', '10:00:00', 1),
(5, 1, '2025-01-31', '10:30:00', '11:30:00', 1),
(6, 1, '2025-01-31', '11:30:00', '12:30:00', 1),
(7, 1, '2025-01-31', '13:30:00', '14:30:00', 1),
(8, 1, '2025-01-31', '14:30:00', '15:30:00', 1),
(9, 1, '2025-01-31', '15:30:00', '16:30:00', 1),
(10, 1, '2025-01-31', '16:30:00', '17:30:00', 1),
(11, 2, '2025-02-01', '09:00:00', '10:00:00', 1),
(12, 2, '2025-02-01', '10:30:00', '11:30:00', 1),
(13, 2, '2025-02-01', '11:30:00', '12:30:00', 1),
(14, 2, '2025-02-01', '13:30:00', '14:30:00', 1),
(15, 2, '2025-02-01', '14:30:00', '15:30:00', 1),
(16, 2, '2025-02-01', '15:30:00', '16:30:00', 1),
(17, 2, '2025-02-01', '16:30:00', '17:30:00', 1),
(18, 3, '2025-02-01', '09:00:00', '10:00:00', 1),
(19, 3, '2025-02-01', '10:00:00', '11:00:00', 1),
(20, 3, '2025-02-01', '11:00:00', '12:00:00', 1),
(21, 3, '2025-02-01', '12:00:00', '13:00:00', 1),
(22, 3, '2025-02-01', '13:00:00', '14:00:00', 1),
(23, 4, '2025-01-31', '09:00:00', '10:00:00', 1),
(24, 4, '2025-01-31', '10:30:00', '11:30:00', 1),
(25, 4, '2025-01-31', '11:30:00', '12:30:00', 1),
(26, 4, '2025-01-31', '13:30:00', '14:30:00', 1),
(27, 4, '2025-01-31', '14:30:00', '15:30:00', 1),
(28, 4, '2025-01-31', '15:30:00', '16:30:00', 1),
(29, 4, '2025-01-31', '16:30:00', '17:30:00', 1),
(30, 5, '2025-02-01', '09:00:00', '10:00:00', 1),
(31, 5, '2025-02-01', '10:30:00', '11:30:00', 1),
(32, 5, '2025-02-01', '11:30:00', '12:30:00', 1),
(33, 5, '2025-02-01', '13:30:00', '14:30:00', 1),
(34, 5, '2025-02-01', '14:30:00', '15:30:00', 1),
(35, 5, '2025-02-01', '15:30:00', '16:30:00', 1),
(36, 5, '2025-02-01', '16:30:00', '17:30:00', 1),
(37, 6, '2025-02-01', '13:00:00', '14:00:00', 1),
(38, 6, '2025-02-01', '14:00:00', '15:00:00', 1),
(39, 6, '2025-02-01', '15:00:00', '16:00:00', 1),
(40, 6, '2025-02-01', '16:00:00', '17:00:00', 1),
(41, 6, '2025-02-01', '17:00:00', '18:00:00', 1),
(42, 7, '2025-02-01', '09:00:00', '10:00:00', 1),
(43, 7, '2025-02-01', '10:00:00', '11:00:00', 1),
(44, 7, '2025-02-01', '11:00:00', '12:00:00', 1),
(45, 7, '2025-02-01', '12:00:00', '13:00:00', 1),
(46, 7, '2025-02-01', '13:00:00', '14:00:00', 1),
(47, 8, '2025-01-31', '09:00:00', '10:00:00', 1),
(48, 8, '2025-01-31', '10:30:00', '11:30:00', 1),
(49, 8, '2025-01-31', '11:30:00', '12:30:00', 1),
(50, 8, '2025-01-31', '13:30:00', '14:30:00', 1),
(51, 8, '2025-01-31', '14:30:00', '15:30:00', 1),
(52, 8, '2025-01-31', '15:30:00', '16:30:00', 1),
(53, 8, '2025-01-31', '16:30:00', '17:30:00', 1),
(54, 9, '2025-02-01', '09:00:00', '10:00:00', 1),
(55, 9, '2025-02-01', '10:30:00', '11:30:00', 1),
(56, 9, '2025-02-01', '11:30:00', '12:30:00', 1),
(57, 9, '2025-02-01', '13:30:00', '14:30:00', 1),
(58, 9, '2025-02-01', '14:30:00', '15:30:00', 1),
(59, 9, '2025-02-01', '15:30:00', '16:30:00', 1),
(60, 9, '2025-02-01', '16:30:00', '17:30:00', 1),
(61, 10, '2025-02-01', '13:00:00', '14:00:00', 1),
(62, 10, '2025-02-01', '14:00:00', '15:00:00', 1),
(63, 10, '2025-02-01', '15:00:00', '16:00:00', 1),
(64, 10, '2025-02-01', '16:00:00', '17:00:00', 1),
(65, 10, '2025-02-01', '17:00:00', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `диагнозы`
--

CREATE TABLE `диагнозы` (
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `диагнозы`
--

INSERT INTO `диагнозы` (`code`, `name`) VALUES
('A37', 'Коклюш'),
('B01', 'Ветряная оспа'),
('E04', 'Нетоксический зоб'),
('E05', 'Тиреотоксикоз'),
('E66', 'Ожирение'),
('G20', 'Болезнь Паркинсона'),
('G35', 'Рассеянный склероз'),
('G43', 'Мигрень'),
('H10', 'Конъюнктивит'),
('H25', 'Старческая катаракта'),
('H40', 'Глаукома'),
('I20', 'Стенокардия'),
('I21', 'Острый инфаркт миокарда'),
('I48', 'Фибрилляция предсердий'),
('J06', 'Острая респираторная инфекция верхних дыхательных путей'),
('J21', 'Острый бронхиолит'),
('K35', 'Острый аппендицит'),
('K40', 'Паховая грыжа'),
('K52', 'Гастроэнтерит неинфекционный'),
('M17', 'Гонартроз (артроз коленного сустава)'),
('M41', 'Сколиоз'),
('M75', 'Плечелопаточный периартрит'),
('N20', 'Мочекаменная болезнь'),
('N30', 'Цистит'),
('N41', 'Хронический простатит'),
('N80', 'Эндометриоз'),
('N85', 'Гиперплазия эндометрия'),
('O23', 'Инфекция мочеполовых путей при беременности'),
('R50', 'Лихорадка неясного генеза'),
('S82', 'Перелом костей голени');

-- --------------------------------------------------------

--
-- Структура таблицы `пациенты`
--

CREATE TABLE `пациенты` (
  `medcard_number` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `address` text NOT NULL,
  `gender` enum('М','Ж') NOT NULL,
  `discount` decimal(5,2) DEFAULT 0.00,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `пациенты`
--

INSERT INTO `пациенты` (`medcard_number`, `full_name`, `birth_date`, `address`, `gender`, `discount`, `email`, `password_hash`) VALUES
(1001, 'Иванов Алексей Петрович', '1985-03-15', 'ул. Ленина 25-34', 'М', 0.00, 'ivanov@mail.com', '$2a$10$dy9NY1JXpuotxgdNgHOJae4AvVmH.LY93nKFnjPmZt.Bzq.2AQOMC'),
(1002, 'Петрова Мария Сергеевна', '1992-07-22', 'пр. Мира 12-8', 'Ж', 10.00, 'petrova@mail.com', '$2a$10$tUBFYc1nf/YHOunE96MtY.YQYAdFi6vwjRbkFkWfDFD.45x7xv.QK'),
(1003, 'Сидоров Дмитрий Игоревич', '1978-11-05', 'ул. Садовая 7-15', 'М', 5.00, 'sidorov@mail.com', '$2a$10$xh.3WiNWHHg2ZHXPqxauzeMl3.7Su1mpc4RknXYlJghiems3mud12'),
(1004, 'Кузнецова Елена Викторовна', '2001-01-30', 'пл. Победы 3-42', 'Ж', 0.00, 'kuznetsova@mail.com', '$2a$10$FidU3OkkWbZGEBT0SjY9c.zLIXSp/stURrlUyeQ4fEC.zW7GryYSi'),
(1005, 'Смирнов Артем Александрович', '1999-12-12', 'ул. Весенняя 18-9', 'М', 15.00, 'smirnov@mail.com', '$2a$10$q/oC1TbtLXzuKIFDrLWNpO6nrIBIIm78/GNqfWMxw2jP9Ov3G1e/m'),
(1006, 'Васильева Ольга Дмитриевна', '1982-04-18', 'пр. Космонавтов 33-7', 'Ж', 0.00, 'vasileva@mail.com', '$2a$10$V7h2dvmd4UtZ5ZbQ0l8ePuFX486mAURUW1eEBwCyZorzwPLS5BF4S'),
(1007, 'Попов Иван Николаевич', '1975-09-25', 'ул. Зеленая 11-21', 'М', 20.00, 'popov@mail.com', '$2a$10$qkaySaw/6VWvyzp6ulX0EebT2YOFnNobR.A9Ut6.GZFK0bYOci83O'),
(1008, 'Новикова Анастасия Павловна', '1995-06-08', 'ул. Центральная 5-13', 'Ж', 0.00, 'novikova@mail.com', '$2a$10$XqqMNtNQsTEv8UM.bo2EcuD3xsHH0BxA59wypn2CUWWrxtIxgISL.'),
(1009, 'Федоров Сергей Васильевич', '1988-02-14', 'пр. Строителей 9-45', 'М', 10.00, 'fedorov@mail.com', '$2a$10$rTPu1UigQUYdAx/gcirL9eug4NiwC1LlQ6b494.zJZHqV6bHyJjeu'),
(1010, 'Морозова Татьяна Олеговна', '2003-08-11', 'ул. Школьная 2-19', 'Ж', 0.00, 'morozova@mail.com', '$2a$10$.iKZxyewRNkJXu7amz/o6.q2oQz6Skbvdm75vmapYxR82qmx52VZW'),
(123456, 'Иванов Иван Иванович', '1990-05-15', '', 'М', 0.00, 'test@mail.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(706228, 'Кузьмин Андрей Сергеевич', '2024-12-05', 'ул. Школьная 137', 'М', 0.00, 'test3@mail.com', '$2y$10$mPnG9n.d62/PKv6wd3l8IOiKjZomw2IxERqadrjS4qSnI1OiY.rf2'),
(921280, 'Петров Петр Петрович', '2025-01-15', 'Не указан', '', 0.00, 'test12@mail.ru', '$2y$10$aBsJr0o34IpvJNIPClPWU.A7qANGvBpHHRPLbd1rwKxLMbmoSjvZu'),
(982568, 'Анна Ивановна Пичка', '2025-01-04', 'Не указан', '', 0.00, 'test1212@mail.com', '$2y$10$EX29L..v2Qdk2ONht7CiruG2kcit98T.DZJNnkW/3iDm3mqhRnG.K');

-- --------------------------------------------------------

--
-- Структура таблицы `приемы`
--

CREATE TABLE `приемы` (
  `ticket_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `diagnosis_code` varchar(10) DEFAULT NULL,
  `visit_date` date NOT NULL,
  `purpose` enum('консультация','обследование','лечение') NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `payment_status` enum('ожидает','оплачен','отменен') DEFAULT 'ожидает',
  `payment_id` varchar(36) DEFAULT NULL,
  `visit_time` time DEFAULT NULL,
  `status` enum('активна','отменена') DEFAULT 'активна',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `приемы`
--

INSERT INTO `приемы` (`ticket_id`, `doctor_id`, `patient_id`, `diagnosis_code`, `visit_date`, `purpose`, `cost`, `payment_status`, `payment_id`, `visit_time`, `status`, `notes`) VALUES
(1, 1, 1001, 'J06', '2024-11-15', 'консультация', 1500.00, 'оплачен', NULL, '09:30:00', 'активна', NULL),
(2, 1, 1001, 'K52', '2024-12-10', 'обследование', 2500.00, 'оплачен', NULL, '14:00:00', 'активна', NULL),
(3, 2, 1002, 'K40', '2024-10-20', 'лечение', 18000.00, 'оплачен', NULL, '11:15:00', 'активна', NULL),
(4, 5, 1002, 'I20', '2024-09-05', 'консультация', 2000.00, 'оплачен', NULL, '10:00:00', 'активна', NULL),
(5, 3, 1003, 'H10', '2025-01-05', 'обследование', 3200.00, 'оплачен', NULL, '16:45:00', 'активна', NULL),
(6, 3, 1003, 'H25', '2024-08-12', 'лечение', 15000.00, 'отменен', NULL, '12:30:00', 'активна', NULL),
(7, 4, 1004, 'G43', '2024-07-22', 'консультация', 1800.00, 'оплачен', NULL, '09:00:00', 'активна', NULL),
(8, 4, 1004, 'G20', '2024-06-10', 'обследование', 4500.00, 'оплачен', NULL, '15:20:00', 'активна', NULL),
(9, 5, 1005, 'I21', '2024-05-15', 'лечение', 22000.00, 'оплачен', NULL, '13:10:00', 'активна', NULL),
(10, 5, 1005, 'I48', '2024-04-03', 'консультация', 1700.00, 'оплачен', NULL, '10:45:00', 'активна', NULL),
(11, 6, 1006, 'B01', '2024-03-12', 'лечение', 3000.00, 'оплачен', NULL, '08:30:00', 'активна', NULL),
(12, 6, 1006, 'J21', '2024-02-28', 'обследование', 2800.00, 'оплачен', NULL, '11:00:00', 'активна', NULL),
(13, 7, 1007, 'M17', '2024-01-10', 'консультация', 2000.00, 'оплачен', NULL, '14:15:00', 'активна', NULL),
(14, 7, 1007, 'M41', '2023-12-18', 'лечение', 12000.00, 'оплачен', NULL, '16:00:00', 'активна', NULL),
(15, 8, 1008, 'E66', '2023-11-05', 'обследование', 3500.00, 'оплачен', NULL, '10:30:00', 'активна', NULL),
(16, 8, 1008, 'E05', '2023-10-20', 'лечение', 18000.00, 'оплачен', NULL, '13:45:00', 'активна', NULL),
(17, 9, 1009, 'N20', '2023-09-15', 'консультация', 1700.00, 'оплачен', NULL, '09:15:00', 'отменена', NULL),
(18, 9, 1009, 'N30', '2023-08-22', 'лечение', 9000.00, 'отменен', NULL, '15:30:00', 'активна', NULL),
(19, 10, 1010, 'N80', '2023-07-10', 'обследование', 4200.00, 'оплачен', NULL, '12:00:00', 'активна', NULL),
(20, 10, 1010, 'O23', '2023-06-05', 'лечение', 15000.00, 'оплачен', NULL, '14:20:00', 'активна', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `администраторы`
--

CREATE TABLE `администраторы` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `врачи`
--

CREATE TABLE `врачи` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialty` varchar(50) NOT NULL,
  `category` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `врачи`
--

INSERT INTO `врачи` (`id`, `full_name`, `specialty`, `category`, `email`, `password_hash`) VALUES
(1, 'Семенов Андрей Владимирович', 'Терапевт', 'Высшая', 'semenov@clinic.ru', '$2a$10$HAOn6MKDfFIHLWc/6NIVz.hb2vjREzR.i4V/Mitn6XJP97F4Qlq8C'),
(2, 'Захарова Ирина Станиславовна', 'Хирург', 'Первая', 'zakharova@clinic.ru', '$2a$10$NSJWySfPn/Ad83WVSOYGPuuoKfr7DTIOuhEkFYUlHGi.OQrUCA2iq'),
(3, 'Козлов Михаил Александрович', 'Офтальмолог', 'Вторая', 'kozlov@clinic.ru', '$2a$10$XK2oCAJ/5anAsp5zfJGU9ulKUzfAKhRu2ntvuNiOeIzuB2mU7XqGW'),
(4, 'Павлова Екатерина Сергеевна', 'Невролог', 'Высшая', 'pavlova@clinic.ru', '$2a$10$FKZYIBEFmH0fP9ZgetE18.4rMZCJRRZtO.vVmoQYmyEO6rfGoa/Bi'),
(5, 'Григорьев Денис Олегович', 'Кардиолог', 'Первая', 'grigoriev@clinic.ru', '$2a$10$eoU2AkWCEDBmtWU0KZ78uuPM8rEexkjSYX6GxUXYCUTZ8TpQLqbVO'),
(6, 'Соколова Анна Викторовна', 'Педиатр', 'Вторая', 'sokolova@clinic.ru', '$2a$10$OXO4.AqdfyLhVYBRMvyQsOXJYEcHLtSOB2AORmVz5.aeYb/5SAfgK'),
(7, 'Белов Алексей Игоревич', 'Ортопед', 'Высшая', 'belov@clinic.ru', '$2a$10$3e3ylmURp5qoBhmrY0r7PuBmH6SqOWQJESu60OIwsR/ApNOTfQILK'),
(8, 'Мельникова Ольга Дмитриевна', 'Эндокринолог', 'Первая', 'melnikova@clinic.ru', '$2a$10$zIZ3gNaIHy8kXthpcX2KQuP/78is2.sV6Ng5WxKd12vIxmGOVtpSy'),
(9, 'Кудрявцев Павел Андреевич', 'Уролог', 'Вторая', 'kudryavtsev@clinic.ru', '$2a$10$0.78QXPI6QLgIf/DS76wQeeRGrM85HsY9ncXA1Y9yMbQwgD0f/8Mq'),
(10, 'Сорокина Марина Валерьевна', 'Гинеколог', 'Высшая', 'sorokina@clinic.ru', '$2a$10$qhb5vsgvBPTcJmv1G56wFuhh3Hvdt2VUOMMqsEtlxLe6ddDvrvtMa');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Индексы таблицы `диагнозы`
--
ALTER TABLE `диагнозы`
  ADD PRIMARY KEY (`code`);

--
-- Индексы таблицы `пациенты`
--
ALTER TABLE `пациенты`
  ADD PRIMARY KEY (`medcard_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `medcard_number_UNIQUE` (`medcard_number`);

--
-- Индексы таблицы `приемы`
--
ALTER TABLE `приемы`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `diagnosis_code` (`diagnosis_code`);

--
-- Индексы таблицы `администраторы`
--
ALTER TABLE `администраторы`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `врачи`
--
ALTER TABLE `врачи`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT для таблицы `приемы`
--
ALTER TABLE `приемы`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `администраторы`
--
ALTER TABLE `администраторы`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `врачи`
--
ALTER TABLE `врачи`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD CONSTRAINT `doctor_schedule_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `врачи` (`id`);

--
-- Ограничения внешнего ключа таблицы `приемы`
--
ALTER TABLE `приемы`
  ADD CONSTRAINT `приемы_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `врачи` (`id`),
  ADD CONSTRAINT `приемы_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `пациенты` (`medcard_number`),
  ADD CONSTRAINT `приемы_ibfk_3` FOREIGN KEY (`diagnosis_code`) REFERENCES `диагнозы` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
