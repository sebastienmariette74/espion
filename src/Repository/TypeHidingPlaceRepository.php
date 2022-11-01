<?php

namespace App\Repository;

use App\Entity\TypeHidingPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeHidingPlace>
 *
 * @method TypeHidingPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHidingPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHidingPlace[]    findAll()
 * @method TypeHidingPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHidingPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeHidingPlace::class);
    }

    public function save(TypeHidingPlace $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeHidingPlace $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
