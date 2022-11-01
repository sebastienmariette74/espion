<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function save(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPaginated($page, $limit, $filters, $querySearch)
    {
        $query = $this->createQueryBuilder('m')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->orderBy('m.codeName');

        $innerJoins = [];
        if ($filters != null) {
            foreach ($filters as $key => $value) {
                $string1 = "m." . $key;
                $string2 = $key[0] . $key[1];
                $string3 = $key[0] . $key[1] . ".id = :" . $key;
                $innerJoins[] = [$string1, $string2, $string3, $key, $value];
            }
            foreach ($innerJoins as $innerJoin) {
                $query->innerJoin($innerJoin[0], $innerJoin[1]);
            }
            foreach ($innerJoins as $innerJoin) {
                $query->andWhere($innerJoin[2]);
            }
            foreach ($innerJoins as $innerJoin) {
                $query->setParameter($innerJoin[3], $innerJoin[4]);
            }
        }

        if ($querySearch != null) {
            $query->andWhere('m.codeName LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('m.codeName');
        }

        return $query->getQuery()->getResult();
    }

    public function getTotal($filters, $querySearch)
    {
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m)');

        $innerJoins = [];
        if ($filters != null) {
            foreach ($filters as $key => $value) {
                $string1 = "m." . $key;
                $string2 = $key[0] . $key[1];
                $string3 = $key[0] . $key[1] . ".id = :" . $key;
                $innerJoins[] = [$string1, $string2, $string3, $key, $value];
            }
            foreach ($innerJoins as $innerJoin) {
                $query->innerJoin($innerJoin[0], $innerJoin[1]);
            }
            foreach ($innerJoins as $innerJoin) {
                $query->andWhere($innerJoin[2]);
            }
            foreach ($innerJoins as $innerJoin) {
                $query->setParameter($innerJoin[3], $innerJoin[4]);
            }
        }

        if ($querySearch != null) {
            $query->andWhere('m.codeName LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('m.codeName');
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}
