<?php

namespace App\Listeners;

use App\Events\PasswordRecoveryAttempted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Classes\SMSGateway;

class SendPasswordRecoveryCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PasswordRecoveryAttempted  $event
     * @return void
     */
    public function handle(PasswordRecoveryAttempted $event)
    {
        $emailOrPhone = $event->emailOrPhone;
        $code         = $event->code;

        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            $this->sendEmail($emailOrPhone, $code);
        }else {
            $this->sendSMS($emailOrPhone, $code);
        }
    }

    private function sendSMS($number, $code)
    {
        $SMSGateway = new SMSGateway();
        $SMSGateway->sendPasswordRecoveryCode($number, $code);
    }

    private function sendEmail($email, $code)
    {
        // TODO: Send Email
        return true;
    }
}
