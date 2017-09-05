<?php

namespace AppBundle\Service;

use Twilio\Rest\Client;

/**
 * Class SmsService
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class SmsService
{
    /**
     * @var Client
     */
    private $twilioClient;

    /**
     * @var string
     */
    private $senderPhone;

    /**
     * @var string
     */
    private $projectName;

    /**
     * SmsService constructor.
     *
     * @param array $twilio
     * @param string $projectName
     */
    public function __construct(
        array $twilio,
        string $projectName)
    {
        $this->twilioClient = new Client(
            $twilio['account_id'],
            $twilio['auth_token']
        );
        $this->senderPhone = $twilio['sender_phone'];
        $this->projectName = $projectName;
    }

    /**
     * Send SMS to user with auth code
     *
     * @param string $subscriberPhone
     * @param string $rawAuthCode
     * @return void
     */
    public function send(string $subscriberPhone, string $rawAuthCode)
    {
        $this->twilioClient->messages->create(
            $subscriberPhone,
            [
                'from' => $this->senderPhone,
                'body' => sprintf(
                    'Your authentication code for %s is %s',
                    $this->projectName,
                    $rawAuthCode
                ),
            ]
        );
    }
}