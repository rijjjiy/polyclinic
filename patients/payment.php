<?php
session_start();
require '../includes/config.php';

// Проверка авторизации и получение данных о приеме
if (!isset($_SESSION['patient_id']) || !isset($_GET['appointment'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("
    SELECT p.*, d.full_name AS doctor_name 
    FROM Приемы p
    JOIN Врачи d ON p.doctor_id = d.id
    WHERE p.ticket_id = ? AND p.patient_id = ?
");
$stmt->execute([$_GET['appointment'], $_SESSION['patient_id']]);
$appointment = $stmt->fetch();

if (!$appointment) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оплата приема</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Оплата приема</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Оплата медицинской услуги</h4>
                    </div>
                    <div class="card-body">
                        <div class="payment-details mb-4">
                            <h5>Детали приема:</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Врач:</strong> <?= $appointment['doctor_name'] ?></p>
                                    <p><strong>Дата:</strong> <?= date('d.m.Y', strtotime($appointment['visit_date'])) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Время:</strong> <?= substr($appointment['visit_time'], 0, 5) ?></p>
                                    <p><strong>Сумма:</strong> <?= number_format($appointment['cost'], 2) ?> ₽</p>
                                </div>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <h5 class="mb-3">Выберите способ оплаты:</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card payment-card" data-method="card">
                                        <div class="card-body text-center">
                                            <img src="../assets/img/credit-card.svg" alt="Карта" width="60" class="mb-3">
                                            <h6>Банковская карта</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card payment-card" data-method="qiwi">
                                        <div class="card-body text-center">
                                            <img src="../assets/img/qiwi.svg" alt="QIWI" width="60" class="mb-3">
                                            <h6>QIWI Кошелек</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="paymentForm" action="payment_process.php" method="post" class="mt-4 d-none">
                            <input type="hidden" name="appointment_id" value="<?= $appointment['ticket_id'] ?>">
                            <div id="cardFields">
                                <div class="mb-3">
                                    <label class="form-label">Номер карты</label>
                                    <div class="input-group">
                                        <input type="text" name="card_number" class="form-control" placeholder="0000 0000 0000 0000" 
                                               pattern="\d{16}" maxlength="16" data-mask="0000 0000 0000 0000">
                                        <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Срок действия</label>
                                        <input type="text" name="expiry" class="form-control" placeholder="MM/YY" 
                                               pattern="(0[1-9]|1[0-2])\/\d{2}" data-mask="00/00">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">CVV</label>
                                        <input type="text" name="cvv" class="form-control" placeholder="000" 
                                               pattern="\d{3}" maxlength="3" data-mask="000">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-4 py-3">
                                <span class="payment-loader d-none"></span>
                                Подтвердить оплату
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Обработка выбора способа оплаты
        $('.payment-card').click(function() {
            $('.payment-card').removeClass('selected');
            $(this).addClass('selected');
            $('#paymentForm').removeClass('d-none');
        });

        // Маски для полей ввода
        $('[data-mask]').on('input', function() {
            const mask = $(this).data('mask');
            const value = $(this).val().replace(/\D/g,'');
            let maskedValue = '';
            
            for (let i = 0, j = 0; i < mask.length; i++) {
                if (mask[i] === '0') {
                    if (j < value.length) {
                        maskedValue += value[j++];
                    } else {
                        break;
                    }
                } else {
                    maskedValue += mask[i];
                }
            }
            $(this).val(maskedValue);
        });
    </script>
</body>
</html>