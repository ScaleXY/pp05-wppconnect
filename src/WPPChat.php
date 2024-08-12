<?php

namespace ScaleXY\WPPConnect;

use Illuminate\Support\Facades\Http;

class WPPChat extends WPPBaseClient
{
    // List Chats
    public function listChats($id = null, $count = 20)
    {
        $url = '/api/'.$this->session_id.'/list-chats';
        $payload = [
            'count' => $count,
            'direction' => 'after',
        ];
        if (! is_null($id)) {
            $payload['id'] = $id;
        }

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, $payload)
            ->json();
    }

    // Last Seen
    public function lastSeen($phone_number)
    {
        $url = '/api/'.$this->session_id.'/last-seen/'.$phone_number;

        return Http::withToken($this->token)
            ->get(config('services.wppconnect.endpoint').$url)
            ->json();
    }
}
