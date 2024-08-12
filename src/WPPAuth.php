<?php

namespace ScaleXY\WPPConnect;

use Illuminate\Support\Facades\Http;

class WPPAuth extends WPPBaseClient
{
    // Static method to generate token
    public static function generateToken($session_id)
    {
        $url = '/api/'.$session_id.'/'.config('services.wppconnect.secret').'/generate-token';

        return Http::post(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    // Start Session
    public function startSession()
    {
        $url = '/api/'.$this->session_id.'/start-session';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    // Status Session
    public function statusSession()
    {
        $url = '/api/'.$this->session_id.'/status-session';

        return Http::withToken($this->token)
            ->get(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    // Close Session
    public function closeSession()
    {
        $url = '/api/'.$this->session_id.'/close-session';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url)
            ->json();
    }
}
