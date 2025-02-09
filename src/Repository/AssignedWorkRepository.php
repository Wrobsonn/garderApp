<?php

namespace App\Repository;

use App\Entity\AssignedWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssignedWork>
 *
 * @method AssignedWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignedWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignedWork[]    findAll()
 * @method AssignedWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignedWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignedWork::class);
    }
}
