<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Locality;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LocalityController
 *
 * @author Andrey Antonov <apologboy@gmail.com>
 */
class LocalityController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  section="locality",
     *  description="Get locality"
     * )
     *
     *
     *
     * @Rest\Get("/localities/{id}", name="get_locality")
     * @param Locality $locality
     *
     * @return Locality
     */
    public function getLocalityAction(Locality $locality): Locality
    {
        return $locality;
    }
}