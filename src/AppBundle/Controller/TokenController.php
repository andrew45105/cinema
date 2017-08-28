<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class TokenController
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class TokenController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  section="token",
     *  description="Generate auth token for api requests"
     * )
     * @Rest\Post("/token", name="post_token")
     * @Rest\RequestParam(name="phone", requirements="\+?[\d]+", description="phone")
     * @Rest\RequestParam(name="auth_code", description="auth code")
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     */
    public function postTokenAction(ParamFetcherInterface $paramFetcher)
    {
        return $this
            ->get('app.service.token')
            ->generateToken($paramFetcher->all());
    }
}