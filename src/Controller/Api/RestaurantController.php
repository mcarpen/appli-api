<?php

namespace App\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route(path="/api/restaurant")
 */
class RestaurantController
{
    /**
     * @Route(path="/", name="api_restaurants", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function all()
    {
        return new JsonResponse(['coucou']);
    }

    /**
     * @Route(path="/{id}", name="api_restaurant", methods={"GET"}, requirements={"id":"\d+"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function one(int $id)
    {
        return new JsonResponse(['coucou']);
    }

    /**
     * @Route(path="/", name="api_restaurant_post", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create()
    {
        return new JsonResponse(['coucou']);
    }
}