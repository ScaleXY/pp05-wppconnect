<?php

namespace ScaleXY\WPPConnect;

use Illuminate\Support\Facades\Http;

class WPPGroup extends WPPBaseClient
{
    // Create Group
    public function createGroup($group_name, $phone_numbers)
    {
        $url = '/api/'.$this->session_id.'/create-group';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'participants' => $phone_numbers,
                'name' => $group_name,
            ])
            ->json();
    }

    // Promote Participant to Admin
    public function addParticipanntGroup($group_id, $phone_number)
    {
        $url = '/api/'.$this->session_id.'/add-participant-group';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'groupId' => $group_id,
                'phone' => $phone_number,
            ])
            ->json();
    }

    // Promote Participant to Admin
    public function promoteParticipanntGroup($group_id, $phone_number)
    {
        $url = '/api/'.$this->session_id.'/promote-participant-group';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'groupId' => $group_id,
                'phone' => $phone_number,
            ])
            ->json();
    }

    // Demote Participant to Admin
    public function demoteParticipanntGroup($group_id, $phone_number)
    {
        $url = '/api/'.$this->session_id.'/demote-participant-group';

        return Http::withToken($this->token)
            ->post(config('services.wppconnect.endpoint').$url, [
                'groupId' => $group_id,
                'phone' => $phone_number,
            ])
            ->json();
    }

    // TODO Set Group Description
    // /api/{session}/group-description
}
