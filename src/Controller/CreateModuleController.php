<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\ModulesEntity;
use App\Repository\ModulesRepository;
use App\Helpers\ModulesMessagesHelper as Helper;

class CreateModuleController extends AbstractController
{
    /**
     * @var ModulesRepository
     */
    private ModulesRepository $modulesRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->modulesRepository = $entityManager->getRepository(ModulesEntity::class);
    }

    /**
     * @Route("/modules/create", methods={"POST"}, name="create-module")
     * 
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
    {
        $request->request->replace(json_decode($request->getContent(), true));

        $name = $request->request->get('name');
        $route = $request->request->get('route');
        $imageName = $request->request->get('imageName');
        $description = $request->request->get('description');

        try {
            $module = new ModulesEntity();
            $module->setName($name);
            $module->setRoute($route);
            $module->setImageName($imageName);
            $module->setDescription($description);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return new JsonResponse([
                'message' => sprintf(Helper::MODULE_NEW_MODULE_MESAGE, $module->getName()),
                'details' => [
                    'id' => $module->getId()
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