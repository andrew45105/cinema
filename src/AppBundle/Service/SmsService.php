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
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $authToken;

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
        $this->accountId = $twilio['account_id'];
        $this->authToken = $twilio['auth_token'];
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
        $client = new Client($this->accountId, $this->authToken);
        $client->messages->create(
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