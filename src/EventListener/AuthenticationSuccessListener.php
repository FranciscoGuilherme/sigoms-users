<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GatewayEntity;
use App\Entity\ModulesEntity;
use App\Repository\GatewayRepository;
use App\Repository\ModulesRepository;

class AuthenticationSuccessListener
{
    /**
     * @var GatewayRepository $gatewayRepository
     */
    private GatewayRepository $gatewayRepository;

    /**
     * @var ModulesRepository $modulesRepository
     */
    private ModulesRepository $modulesRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->gatewayRepository = $entityManager->getRepository(GatewayEntity::class);
        $this->modulesRepository = $entityManager->getRepository(ModulesEntity::class);
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $userInfos = $event->getUser();
        $userRole = $userInfos->getRoles()[0];
        $kongToken = $this->gatewayRepository->findAll();

        $event->setData([
            'user' => $event->getData(),
            'modules' => $this->getModules($userRole),
            'gateway' => $kongToken[0]
        ]);
    }

    /**
     * @param string $role Role do usuário
     * 
     * @return array Lista de roles do usuário
     */
    private function getModules(string $role): array
    {
        switch ($role) {
            case "ROLE_FULL": return $this->modulesRepository->findAll();
            case "ROLE_GN": return $this->modulesRepository->findByRole($role);
            default: return [];
        }
    }
}