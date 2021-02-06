<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class GatewayRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT
                    gateway.token
                 FROM App:GatewayEntity gateway'
            )
            ->getResult();
    }
}