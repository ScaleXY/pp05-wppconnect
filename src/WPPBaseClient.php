<?php

namespace ScaleXY\WPPConnect;

class WPPBaseClient
{
    public $session_id = '';

    public $token = '';

    public function __construct(string $session_id, ?string $token)
    {
        $this->session_id = $session_id;
        if (! is_null($token)) {
            $generated_token_response = WPPAuth::generateToken($session_id);
            $this->token = $generated_token_response['token'];
        }
    }
}
