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
     * SmsService constructor.
     *
     * @param string $accountId
     * @param string $authToken
     * @param $senderPhone
     */
    public function __construct(
        string $accountId,
        string $authToken,
        string $senderPhone)
    {
        $this->accountId = $accountId;
        $this->authToken = $authToken;
        $this->senderPhone = $senderPhone;
    }

    /**
     * Send SMS to user with auth code
     *
     * @param string $subscriberPhone
     * @param string $authCode
     * @return void
     */
    public function send(string $subscriberPhone, string $authCode)
    {
        $client = new Client($this->accountId, $this->authToken);
        $client->messages->create(
            $subscriberPhone,
            [
                'from' => $this->senderPhone,
                'body' => "You authentication code is {$authCode}",
            ]
        );
    }
}