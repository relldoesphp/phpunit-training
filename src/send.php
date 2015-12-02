<?php

require_once __DIR__ . '/../vendor/autoload.php';

$sid = getenv('TWILIO_SID');
$token = getenv('TWILIO_TOKEN');
$phone = getenv('TWILIO_PHONE');

$twilioClient = new Services_Twilio($sid, $token);
$twilioService = new \In2it\Phpunit\Service\Twilio($twilioClient, $phone);

$messages = $twilioService->sendMessage(
    array ('+32479922951'),
    'Hey there, don\'t you love PHPUnit just like me?'
);
var_dump($messages);
echo PHP_EOL;