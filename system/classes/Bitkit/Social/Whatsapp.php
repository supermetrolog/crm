<?php
namespace Bitkit\Social;
class Whatsapp
{

    public function __construct($url, $token)
    {
        $this->token = $token;
        $this->url = $url;
    }

    public function sendMessage($destination_number, $text)
    {
        $data = [
            'phone' => $destination_number, // Телефон получателя
            'body' => $text, // Сообщение
        ];
        $json = json_encode($data); // Закодируем данные в JSON
        // URL для запроса POST /message
        $url_full = $this->url.'message?token='.$this->token;
        // Сформируем контекст обычного POST-запроса
        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]
        ]);
        // Отправим запрос
        if($result = file_get_contents($url_full, false, $options)){
            echo 1111;
        }
    }
}