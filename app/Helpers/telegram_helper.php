<?php

use CodeIgniter\Config\Services;

if (!function_exists('send_telegram_message')) {
    /**
     * Kirim pesan ke Telegram via bot
     * 
     * @param string $message Pesan dalam format HTML (Telegram support HTML parse_mode)
     * @return bool Sukses atau gagal
     */
    function send_telegram_message(string $message): bool
    {
        $token = Services::env()->telegram_bot_token ?? null;
        $chatId = Services::env()->telegram_chat_id ?? null;

        if (!$token || !$chatId) {
            log_message('error', 'Telegram: Bot token atau chat ID tidak ditemukan di .env');
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            log_message('error', 'Telegram: Gagal mengirim pesan');
            return false;
        }

        $response = json_decode($result, true);
        if (isset($response['ok']) && $response['ok'] === true) {
            return true;
        } else {
            log_message('error', 'Telegram API error: ' . ($response['description'] ?? 'Unknown'));
            return false;
        }
    }
}