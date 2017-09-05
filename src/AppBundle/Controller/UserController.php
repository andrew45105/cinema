<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations\View;

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
     * @View(serializerGroups={"default", "locality"})
     * @return User
     */
    public function postUserAction(ParamFetcherInterface $paramFetcher): User
    {
        return $this
            ->get('app.service.entity.user')
            ->create($paramFetcher->all());
    }

    /**
     * @ApiDoc(
     *  section="user",
     *  description="Get user"
     * )
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Get("/users/{id}", name="get_user")
     * @param User $user
     * @View(serializerGroups={"default", "locality", "managers", "orders"})
     * @return User
     */
    public function getUserAction(User $user): User
    {
        return $user;
    }

    /**
     * @ApiDoc(
     *  section="user",
     *  description="Get users"
     * )
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Get("/users", name="get_users")
     * @Rest\QueryParam(name="_page", map=true, description="_page[number]=1; page[size]=10")
     * @param ParamFetcherInterface $paramFetcher
     * @View(serializerGroups={"default", "locality"})
     * @return array
     */
    public function getUsersAction(ParamFetcherInterface $paramFetcher): array
    {
        $pageMap = $paramFetcher->get('_page');
        $page = $pageMap['number'] ?? 1;
        $limit = $pageMap['size'] ?? User::LIMIT;
        $service = $this->get('app.service.entity.user');
        $query = $service->getQuery();
        $result = $service->paginate($query, $page, $limit);

        return $result;
    }

    /**
     * @ApiDoc(
     *  section="user",
     *  description="Get current user"
     * )
     *
     * @Security("user == targetUser")
     *
     * @Rest\Get("/users/me", name="get_me_user")
     * @View(serializerGroups={"default", "locality", "managers", "orders"})
     * @return User
     */
    public function getMeUserAction(): User
    {
        return $this->getUser();
    }

    /**
     * @ApiDoc(
     *  section="user",
     *  description="Create new auth code for user"
     * )
     *
     * @Rest\Post("/users/code", name="post_user_code")
     * @Rest\RequestParam(name="phone", requirements="\+?[\d]+", description="phone")
     * @param ParamFetcherInterface $paramFetcher
     * @View(serializerGroups={"default", "locality"})
     * @return User
     */
    public function postUserCodeAction(ParamFetcherInterface $paramFetcher): User
    {
        return $this
            ->get('app.service.entity.user')
            ->createAuthCode($paramFetcher->get('phone'));
    }

    /**
     * @ApiDoc(
     *  section="user",
     *  description="Update an user"
     * )
     *
     * @Security("user == targetUser || has_role('ROLE_ADMIN')")
     *
     * @Rest\Patch("/users", name="patch_user")
     * @Rest\RequestParam(name="locality", strict=false, requirements="\d+", description="locality id")
     * @Rest\RequestParam(name="firstName", strict=false, description="first name")
     * @Rest\RequestParam(name="lastName", strict=false, description="last name")
     * @Rest\RequestParam(name="roles", map=true, strict=false, description="list of roles")
     * @Rest\RequestParam(name="enabled", strict=false, requirements="(0|1)", description="enable or disable user")
     * @param ParamFetcherInterface $paramFetcher
     * @View(serializerGroups={"default", "locality"})
     * @return User
     */
    public function patchUserAction(ParamFetcherInterface $paramFetcher): User
    {
        return $this
            ->get('app.service.entity.user')
            ->update($this->getUser(), $paramFetcher->all());
    }
}