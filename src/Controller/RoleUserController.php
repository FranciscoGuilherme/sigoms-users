<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleUserController extends AbstractController
{
    /**
     * @Route("/users/roles/add", methods={"POST"}, name="addRoles")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function role(Request $request): JsonResponse
    {
        $request->request->replace(json_decode($request->getContent(), true));

        $userId = $request->request->get('userId');
        $role = $request->request->get('role');
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        if (!$user) {
            return new JsonResponse([
                'message' => 'Usuario nao encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($this->roleExists($user, $role)) {
            return new JsonResponse([
                'message' => 'Role ja configurada para o usuario'
            ], Response::HTTP_OK);
        }

        try {
            $roles = $user->getRoles();
            $roles[] = $role;

            $user->setRoles($roles);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Role ' . $role . ' adicionada ao usuario',
                'details' => [
                    'roles' => $user->getRoles()
                ]
            ], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Ocorreu um erro durante o salvamento'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param object $user
     * @param string $role
     *
     * @return bool
     */
    private function roleExists(object $user, string $role): bool
    {
        if (array_search($role, $user->getRoles()) !== false) {
            return true;
        }

        return false;
    }
}