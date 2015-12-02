<?php
namespace In2it\Phpunit\Service;

class Twilio
{
    const MSG_INBOUND = 'inbound';
    const MSG_OUTBOUND = 'outbound';
    const MSG_ALL = 'all';
    /**
     * @var string The Twilio AccountSID
     */
    protected $id;
    /**
     * @var string The Twilio App Token
     */
    protected $token;
    /**
     * @var string A registered Twilio Number
     */
    protected $number;
    /**
     * @var \Services_Twilio
     */
    protected $client;

    /**
     * Twilio constructor.
     *
     * @param \Services_Twilio $twilio
     * @param string $number
     */
    public function __construct(\Services_Twilio $twilio, $number)
    {
        $this->client = $twilio;
        $this->number = $number;
    }

    /**
     * Sends a message to a list of phone numbers with a given message
     * and returns either a successful message or failure cause.
     *
     * @param array $recipients
     * @param string $message
     * @return string
     */
    public function sendMessage(array $recipients, $message)
    {
        $statusMessages = array ();
        foreach ($recipients as $recipient) {
            try {
                $this->client->account->messages->sendMessage(
                    $this->number,
                    $recipient,
                    $message
                );
                $statusMessages[] = 'Message sent to ' . $recipient;
            } catch (\Services_Twilio_RestException $e) {
                $statusMessages[] = 'Could not send message to '
                    . $recipient . ': ' . $e->getMessage();
            }
        }
        return implode(PHP_EOL, $statusMessages);
    }

/**
 * Reads all messages, grouped by type. Returns an array of messages
 * or a failure message.
 *
 * @return string|array
 */
public function readMessages()
{
    $messages = array ();
    try {
        $messages = $this->client->account->messages;
    } catch (\Services_Twilio_RestException $e) {
        return 'Cannot retrieve SMS list: ' . $e->getMessage() . PHP_EOL;
    }
    $filteredMessages = array ();
    foreach ($messages as $message) {
        if (0 === strcmp($this->number, $message->from)) {
            $filteredMessages[self::MSG_OUTBOUND][] = 'Outgoing message "'
                . $message->body . '" to ' . $message->to;
        } elseif (0 === strcmp($this->number, $message->to)) {
            $filteredMessages[self::MSG_INBOUND][] = 'Incoming message "'
                . $message->body . '" from ' . $message->from;
        } else {
            $filteredMessages[self::MSG_ALL][] = 'Message "'
                . $message->body . '" from ' . $message->from
                . ' to ' . $message->to;
        }
    }
    return $filteredMessages;
}
}