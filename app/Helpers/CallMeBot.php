<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CallMeBot
{
    public static function send_message($message)
    {
        if (is_array($message)) {
            $message = http_build_query($message, '', ' ');
        }
        $message = str_replace('&', ' ', $message);
        $message = str_replace('%20', ' ', $message);

        $cellphone = env('CALL_ME_BOT_CELLPHONE');
        $api_key = env('CALL_ME_BOT_API_KEY');
        $url = 'https://api.callmebot.com/whatsapp.php?phone=' . $cellphone . '&text=' . $message . '&apikey=' . $api_key;
        Http::get($url);
    }
}
