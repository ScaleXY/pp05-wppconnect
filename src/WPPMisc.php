<?php

namespace ScaleXY\WPPConnect;

use Illuminate\Support\Facades\Http;

class WPPMisc extends WPPBaseClient
{
    // Get Phone Number
    public function getPhoneNumber()
    {
        $url = '/api/'.$this->session_id.'/get-phone-number';

        return Http::withToken($this->token)
            ->get(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    // Check Number Status
    public function checkNumberStatus($phone_number)
    {
        $url = '/api/'.$this->session_id.'/check-number-status/'.$phone_number;

        return Http::withToken($this->token)
            ->get(config('services.wppconnect.endpoint').$url)
            ->json();
    }

    // Check And Handle Number Status
    public function checkAndReportNumberStatus($phone_number, $LoggingClass = null)
    {
        $number_check = $this->checkNumberStatus($phone_number);
        switch ($number_check['response']['numberExists'] ?? null) {
            case true:
                switch ($number_check['response']['canReceiveMessage'] ?? null) {
                    case true:
                        return true;
                        break;
                    case false:
                        self::LogFailedNumber($phone_number, $LoggingClass);

                        return false;
                        break;
                }
                break;
            case false:
                self::LogFailedNumber($phone_number, $LoggingClass);

                return false;
                break;
            case null:
                self::LogFailedNumber($phone_number, $LoggingClass);

                return false;
                break;
        }
    }

    public static function LogFailedNumber($phone_number, $LoggingClass = null)
    {
        if (! is_null($LoggingClass)) {
            $LoggingClass::RecordEvent($phone_number);
        }
    }
}
