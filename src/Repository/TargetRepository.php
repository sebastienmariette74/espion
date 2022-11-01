<?php

namespace App\Repository;

use App\Entity\Target;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Target>
 *
 * @method Target|null find($id, $lockMode = null, $lockVersion = null)
 * @method Target|null findOneBy(array $criteria, array $orderBy = null)
 * @method Target[]    findAll()
 * @method Target[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TargetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Target::class);
    }

    public function save(Target $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Target $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPaginated($page, $limit, $filters, $querySearch)
    {
        $query = $this->createQueryBuilder('t')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->orderBy('t.code');

        if ($querySearch != null) {
            $query->andWhere('t.code LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('t.code');
        }

        return $query->getQuery()->getResult();
    }

    public function getTotal($filters, $querySearch)
    {
        $query = $this->createQueryBuilder('t')
            ->select('COUNT(t)');

        if ($querySearch != null) {
            $query->andWhere('t.code LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('t.code');
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}
