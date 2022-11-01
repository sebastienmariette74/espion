<?php

namespace App\Repository;

use App\Entity\TypeMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeMission>
 *
 * @method TypeMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMission[]    findAll()
 * @method TypeMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeMission::class);
    }

    public function save(TypeMission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeMission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
