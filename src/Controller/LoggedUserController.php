<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class LoggedUserController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/users/logged", methods={"GET"}, name="logged")
     *
     * @return JsonResponse
     */
    public function logged(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Usuario logado',
            'details' => [
                'usuario' => $this->security->getUser()->getUsername()
            ]
        ], Response::HTTP_OK);
    }
}
