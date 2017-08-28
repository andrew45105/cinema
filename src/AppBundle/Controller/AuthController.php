<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class AuthController
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class AuthController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  section="auth",
     *  description="Get auth token for api requests"
     * )
     * @Rest\Post("/auth", name="post_auth")
     * @Rest\RequestParam(name="phone", requirements="\+?[\d]+", description="phone")
     * @Rest\RequestParam(name="auth_code", description="auth code")
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     */
    public function postAuthAction(ParamFetcherInterface $paramFetcher)
    {
        return $this
            ->get('app.service.auth')
            ->getAuthToken($paramFetcher->all());
    }
}