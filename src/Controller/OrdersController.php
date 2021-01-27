<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Interfaces\SoapClientInterface;
use App\Helpers\MessagesHelper\OrdersMessagesHelper as Helper;

class OrdersController extends AbstractController
{
    /**
     * @var array $environment
     */
    private array $environment;

    /**
     * @var SoapClientInterface $soapClientInterface
     */
    private SoapClientInterface $soapClientInterface;

    /**
     * @param SoapClientInterface $soapClientInterface
     */
    public function __construct(SoapClientInterface $soapClientInterface)
    {
        $this->environment = include('/app/config/environment.php');
        $this->soapClientInterface = $soapClientInterface;
    }

    /**
     * @Route("/orders", name="orders")
     * 
     * @throws \Exception
     * 
     * @return JsonResponse
     */
    public function action(): JsonResponse
    {
        try {
            $this->soapClientInterface->connect($this->environment['routes']['orders']['service']);
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'message' => Helper::ORDERS_ERROR_CONNECTION_MESSAGE,
                'details' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            $this->soapClientInterface->request(
                $this->environment['routes']['orders']['resource'],
                [
                    'name' => 'Scott'
                ]
            )
        ], Response::HTTP_OK);
    }
}