<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Helpers\MessagesHelper\UsersMessagesHelper as Helper;

class CreateUserController extends AbstractController
{
    /**
     * @Route("/users/create", methods={"POST"}, name="register")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return JsonResponse
     */
    public function action(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $request->request->replace(json_decode($request->getContent(), true));

        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        try {
            $user = new User($username);
            $user->setPassword($encoder->encodePassword($user, $password));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'message' => sprintf(Helper::USER_NEW_USER_MESAGE, $user->getUsername()),
                'details' => [
                    'id' => $user->getId()
                ]
            ], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'message' => Helper::DB_SAVING_ERROR_MESSAGE,
                'details' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
