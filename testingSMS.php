<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

function sendSMSCode($number,$code)
{

// Your Account SID and Auth Token from twilio.com/console
    $account_sid = 'AC6b7144b51434c99fec0a19c5824c00ec';
    $auth_token = '943c467c1367397ffbb0a7d95524d46e';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
    $twilio_number = "+441353210191";

    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
// Where to send a text message (your cell phone?)
        $number,
        array(
            'from' => $twilio_number,
            'body' => 'Your CoRide verification code is #' . $code
)
);
}

