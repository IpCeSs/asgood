<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PingApiController extends Controller
{
    /**
     * @Route("/ping/api", name="ping_api")
     */
    public function pingAction()
    {
        return new JsonResponse(['ping'=>'pong']);
    }
}
