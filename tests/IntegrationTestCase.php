<?php

namespace Tests;

use AppBundle\DataFixtures\ORM\LoadUserData;

/**
 * Class IntegrationTestCase
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
abstract class IntegrationTestCase extends BaseTestCase
{
    /**
     * @var array
     */
    protected $userData;

    /**
     * @var array
     */
    protected $fixtures = [];

    /**
     * @var \Doctrine\Common\DataFixtures\ReferenceRepository
     */
    protected $referenceRepository;

    public function setUp()
    {
        $data = array_merge([
            LoadUserData::class,
        ], $this->fixtures);
        $this->referenceRepository = $this->loadFixtures($data)->getReferenceRepository();
    }

    /**
     * Gets authenticated http client
     *
     * @param string|null $username
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function getAuthenticatedClient(string $username = null)
    {
        $client = self::createClient();

        $username = $username ?? 'mike';
        $password = $this->getContainer()->getParameter('test_users_password');

        $data = [
            'username' => $username,
            'password' => $password,
        ];

        $client->request('POST', '/api/v1.1/token', $data);
        $response = $client->getResponse();
        $content = json_decode($response->getContent());
        $token = $content->access_token;

        if ($token) {
            $client->setServerParameter('HTTP_Authorization', 'Bearer ' . $token);
        }

        return $client;
    }
}