<?php

namespace ScaleXY\WPPConnect;

use Illuminate\Support\Facades\Http;

class WPPMessage extends WPPBaseClient
{
    // Send Message
    public function sendMessage($destination_iden, $message, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $url = '/api/'.$this->session_id.'/send-message';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'message' => $message,
            ])
            ->json();
    }

    // Delete Message
    public function deleteMessage($destination_iden, $message_id, $is_group)
    {
        $url = '/api/'.$this->session_id.'/delete-message';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'messageId' => $message_id,
            ])
            ->json();
    }

    // Send Message Without A Trace
    public function sendMesageWithoutATrace($destination_iden, $message, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $send_message_resp = $this->sendMessage($destination_iden, $message, $is_group);
        if ($send_message_resp['status'] = 'success') {
            $delete_message_resp = $this->deleteMessage($destination_iden, $send_message_resp['response']['id'], $is_group);
        }

        return [
            'send_message_resp' => $send_message_resp,
            'delete_message_resp' => $delete_message_resp ?? [],
        ];
    }

    public function sendVoiceBase64($destination_iden, $clip_base64, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $url = '/api/'.$this->session_id.'/send-voice-base64';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'base64Ptt' => $clip_base64,
            ])
            ->json();
    }

    public function sendVoice($destination_iden, $clip_path, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $url = '/api/'.$this->session_id.'/send-voice-base64';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'path' => $clip_path,
            ])
            ->json();
    }

    public function sendBase64ImageFromURL($destination_iden, $image_url, $message, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $url = '/api/'.$this->session_id.'/send-image';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'filename' => 'image.png',
                'caption' => $message,
                'base64' => 'data:image/png;base64,'.base64_encode(Http::get($image_url)->body()),
            ])
            ->json();
    }

    public function sendBase64Image($destination_iden, $base64_image, $message, $is_group)
    {
        if (! $is_group) {
            $this->CheckNumberAndThrowException($destination_iden);
        }
        $url = '/api/'.$this->session_id.'/send-image';

        $response = Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'phone' => $destination_iden,
                'isGroup' => $is_group,
                'filename' => 'image.png',
                'caption' => $message,
                'base64' => $base64_image,
            ])
            ->json();
        if ($response['status'] != 'success') {
            throw new \Exception(json_encode($response, JSON_PRETTY_PRINT));
        }

        return $response;
    }

    public function getMessages($phone_number, $count = 25, $after_id = null)
    {
        $url = '/api/'.$this->session_id.'/get-messages/'.$phone_number.'@c.us?count='.$count.'&direction=before';
        if (! is_null($after_id)) {
            $url .= '&id='.$after_id;
        }

        return Http::withToken($this->token)
            ->get(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    public function CheckNumberAndThrowException($destination_iden)
    {
        if ((new WPPMisc($this->session_id, $this->token))->checkNumberStatus($destination_iden)) {
            throw new \Exception('Phone number is not valid');
        }
    }
}
