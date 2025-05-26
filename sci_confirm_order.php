<?php
// Конфигурация
$merchant_password = 'pOoM4HMPN8Id4199xdkgVDReo0lqkWjj';

// Получаем данные от Paykassa
$merchant_id = $_POST['merchant_id'];
$order_id    = $_POST['order_id'];
$amount      = $_POST['amount'];
$currency    = $_POST['currency'];
$hash        = $_POST['sign_hash'];

// Проверка подписи
$check_hash = hash('sha256', implode(':', [
    $merchant_id,
    $order_id,
    $amount,
    $currency,
    $merchant_password
]));

if ($hash === $check_hash) {
    // Оплата подтверждена
    file_put_contents("payments.log", "Платеж $order_id на сумму $amount $currency успешно оплачен\n", FILE_APPEND);
    echo 'YES'; // Обязательно вернуть YES
} else {
    // Неверная подпись
    file_put_contents("payments.log", "Ошибка подписи при платеже $order_id\n", FILE_APPEND);
}
