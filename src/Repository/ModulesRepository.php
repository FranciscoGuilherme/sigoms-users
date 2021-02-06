<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ModulesRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT
                    module.name,
                    module.route,
                    module.imageName,
                    module.description
                 FROM App:ModulesEntity module'
            )
            ->getResult();
    }

    public function findByRole(string $role)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT
                    module.name,
                    module.route,
                    module.imageName,
                    module.description,
                    module.userRole
                 FROM App:ModulesEntity module
                 WHERE module.userRole LIKE \'' . $role . '\''
            )
            ->getResult();
    }
}