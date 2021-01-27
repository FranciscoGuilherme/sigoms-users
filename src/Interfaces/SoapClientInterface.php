<?php

namespace App\Interfaces;

interface SoapClientInterface
{
    /**
     * @param string $wsdl
     * 
     * @throws \Exception
     */
    public function connect(string $wsdl): void;

    /**
     * @param string $resource
     * @param array $params
     */
    public function request(string $resource, array $params);
}