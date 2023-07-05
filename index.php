<?php $token = '6198430921:AAGNRrRFN03U2w-Fkp0iT4ZkISIuJp7qAT4';

// Получение входящего обновления от Telegram API
$update = file_get_contents('php://input');
$update = json_decode($update, true);
var_dump($update);
// Проверка наличия команды "/start"
if (isset($update['message']['text']) && $update['message']['text'] == '/start') {
    // Идентификатор чата, куда будет отправлено видео
    $chatId = $update['message']['chat']['id'];

    // Путь к видео-файлу на сервере
    $videoPath = 'https://www.youtube.com/watch?v=mwVVE1tVHls&t=246s';

    // Отправка видео
    sendVideo($token, $chatId, $videoPath);
}

// Функция для отправки видео
function sendVideo($token, $chatId, $videoPath) {
    $videoUrl = 'https://api.telegram.org/bot' . $token . '/sendVideo';

    // Создание объекта CURLFile для отправки видео-файла
    $video = new CURLFile($videoPath);

    // Формирование POST-запроса
    $postData = array(
        'chat_id' => $chatId,
        'video' => $video
    );

    // Инициализация cURL-сессии
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $videoUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Отправка запроса
    $response = curl_exec($ch);

    // Завершение cURL-сессии
    curl_close($ch);
}