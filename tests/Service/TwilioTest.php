<?php
namespace In2it\Test\Phpunit\Service\TwilioTest;

use In2it\Phpunit\Service\Twilio;

class TwilioTest extends \PHPUnit_Framework_TestCase
{
    const VERSION = '2010-04-01';

    /**
     * Generates a our Twilio Service with the Twilio elements mocked out
     * @param \Services_Twilio_Rest_Messages $messages
     * @return \In2it\Phpunit\Service\Twilio
     */
    protected function generateMockTwilioClient(\Services_Twilio_Rest_Messages $messages)
    {
        $client = new \stdClass();
        $uri = 'http://example.com';

        $twilioSdk = $this->getMockBuilder('Services_Twilio')
            ->setMethods(array ())
            ->setConstructorArgs(array ('sid', 'token'))
            ->getMock();

        $twilioRestAccount = $this->getMockBuilder('Services_Twilio_Rest_Account')
            ->setConstructorArgs(array ($client, $uri))
            ->setMethods(array ('__get'))
            ->getMock();

        $twilioRestAccount->expects($this->atLeastOnce())
            ->method('__get')
            ->will($this->returnValue($messages));

        $twilioSdk->account = $twilioRestAccount;

        $twilioPhone = '+1234567890';

        $twilioClient = new Twilio($twilioSdk, $twilioPhone);
        return $twilioClient;
    }
    /**
     * @covers \In2it\Phpunit\Service\Twilio::sendMessage
     */
    public function testSendingMessageTriggersException()
    {
        $client = new \stdClass();
        $uri = 'http://example.com';

        $twilioRestMessages = $this->getMockBuilder('Services_Twilio_Rest_Messages')
            ->setConstructorArgs(array ($client, $uri))
            ->setMethods(array ('sendMessage'))
            ->getMock();

        $twilioRestMessages->expects($this->once())
            ->method('sendMessage')
            ->willThrowException(new \Services_Twilio_RestException(401, 'Invalid credentials'));

        $twilioClient = $this->generateMockTwilioClient($twilioRestMessages);

        $contacts = array ('+1233455678');
        $message = 'Hello world!';
        $result = $twilioClient->sendMessage($contacts, $message);
        $this->assertEquals(
            'Could not send message to +1233455678: Invalid credentials',
            trim($result)
        );
    }

    /**
     * @covers \In2it\Phpunit\Service\Twilio::sendMessage
     */
    public function testSendingMessageIsSuccessful()
    {
        $client = new \stdClass();
        $uri = 'http://example.com';

        $twilioRestMessages = $this->getMockBuilder('Services_Twilio_Rest_Messages')
            ->setConstructorArgs(array ($client, $uri))
            ->setMethods(array ('sendMessage'))
            ->getMock();

        $messageStrings = implode(PHP_EOL, array (
            'Message sent to +1233455678',
            'Message sent to +1029384756',
        ));
        $twilioRestMessages->expects($this->atMost(2))
            ->method('sendMessage')
            ->will($this->returnValue($messageStrings));

        $twilioClient = $this->generateMockTwilioClient($twilioRestMessages);

        $contacts = array ('+1233455678', '+1029384756');
        $message = 'Hello world!';
        $result = $twilioClient->sendMessage($contacts, $message);
        $this->assertEquals(
            $messageStrings,
            $result
        );
    }
}