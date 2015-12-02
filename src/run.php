<?php

require_once __DIR__ . '/../vendor/autoload.php';

$sid = getenv('TWILIO_SID');
$token = getenv('TWILIO_TOKEN');
$phone = getenv('TWILIO_PHONE');

$twilioClient = new Services_Twilio($sid, $token);
$twilioService = new \In2it\Phpunit\Service\Twilio($twilioClient, $phone);

$messages = $twilioService->readMessages();
echo implode(PHP_EOL, $messages[\In2it\Phpunit\Service\Twilio::MSG_INBOUND]);
echo PHP_EOL;