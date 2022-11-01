<?php

namespace App\Repository;

use App\Entity\StatusMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatusMission>
 *
 * @method StatusMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusMission[]    findAll()
 * @method StatusMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusMission::class);
    }

    public function save(StatusMission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatusMission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
