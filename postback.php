<?php

function sendGetRequest($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        file_put_contents('log.txt', "Ошибка при отправке запроса на URL: \n {$url}. Ошибка: \n {$error} \n \n", FILE_APPEND);
    }

    return $response;
}

$subid = $_GET['subid'] ?? '';
$payout = $_GET['payout'] ?? '';
$currency = $_GET['currency'] ?? '';
$status = $_GET['status'] ?? '';
$stream = $_GET['stream'] ?? '';
$source_id = $_GET['source_id'] ?? '';
$offer = $_GET['offer'] ?? '';

$urls = [
    "http://94.142.255.60/0305f14/postback?subid={$subid}&payout={$payout}&currency={$currency}&status={$status}&stream={$stream}&offer={$offer}&sale_status=confirm,approved&rejected_status=reject,decline&lead_status=none&from=shakes.pro",
    "http://94.142.255.58/b41276f/postback?subid={$subid}&payout={$payout}&currency={$currency}&status={$status}&stream={$stream}&offer={$offer}&sale_status=confirm,approved&rejected_status=reject,decline&lead_status=none&from=shakes.pro",
];

foreach ($urls as $url) {
    $response = sendGetRequest($url);
    file_put_contents('log.txt', "Cсылка: \n {$url} \n Ответ от сервера: \n [ {$response} ] \n \n", FILE_APPEND);
}
