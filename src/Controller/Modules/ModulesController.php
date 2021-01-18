<?php

namespace App\Controller\Modules;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ModulesEntity;
use App\Repository\ModulesRepository;

class ModulesController extends AbstractController
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
     * @Route("/modules", methods={"GET"}, name="modules")
     * 
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
    {
        $result = $this->modulesRepository->findAll();

        return new JsonResponse($result, Response::HTTP_OK);
    }
}