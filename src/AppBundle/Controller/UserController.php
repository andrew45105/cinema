<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class UserController
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  section="user",
     *  description="Registration of new user"
     * )
     *
     * @Rest\Post("/users", name="post_user")
     * @Rest\RequestParam(name="phone", requirements="\+?[\d]+", description="phone")
     * @Rest\RequestParam(name="firstName", strict=false, description="first name")
     * @Rest\RequestParam(name="lastName", strict=false, description="last name")
     * @param ParamFetcherInterface $paramFetcher
     * @return User
     */
    public function postUserAction(ParamFetcherInterface $paramFetcher)
    {
        return $this
            ->get('app.service.entity.user')
            ->create($paramFetcher->all());
    }


}