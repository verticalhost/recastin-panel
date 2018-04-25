<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class User
 * @author Soner Sayakci <shyim@posteo.de>
 */
class User extends Controller
{
    /**
     * @Route(path="/api/auth/user")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function me()
    {
        return new JsonResponse($this->getUser());
    }

    /**
     * @Route(path="/api/auth/refresh")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function refresh()
    {
        return new JsonResponse(['success' => true]);
    }
}