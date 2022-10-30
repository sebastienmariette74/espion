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
            // ->where('u.roles LIKE :role')
            // ->setParameter('role', '%"' . $role . '"%')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->orderBy('m.codeName');

        // dump($filters);

            $innerJoins = [];
            if ( $filters != null) {
                foreach ($filters as $key=>$value) {
                // dump($filter);
                $string1 = "m.".$key;
                $string2 = $key[0].$key[1];
                $string3 = $key[0].$key[1].".id = :".$key;
                $innerJoins[] = [$string1, $string2, $string3, $key, $value];

                // $query
                //     ->innerJoin($string1, $string2)
                //     ->andWhere($string3)
                //     ->setParameter('filter', $value);
                }
                // dump($innerJoins);
                foreach ($innerJoins as $innerJoin) {
                    $query->innerJoin($innerJoin[0], $innerJoin[1]);
                }
                foreach ($innerJoins as $innerJoin) {
                    $query->andWhere($innerJoin[2]);
                }
                foreach ($innerJoins as $innerJoin) {
                    $query->setParameter($innerJoin[3], $innerJoin[4]);
                }
                    // $query->setParameters($parameters);
            }


        // if ($speciality != '') {
        //     $query
        //         ->innerJoin('m.speciality', 's')
        //         ->andWhere('s.name = :speciality')
        //         ->setParameter('speciality', $speciality);
        // }

        // if ($filter === 'disabled') {
        //     $query->andWhere('u.isActivated = false');
        // }

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
        // ->where('u.roles LIKE :role')
        // ->setParameter('role', '%"' . $role . '"%');


        $innerJoins = [];
            if ( $filters != null) {
                foreach ($filters as $key=>$value) {
                // dump($filter);
                $string1 = "m.".$key;
                $string2 = $key[0].$key[1];
                $string3 = $key[0].$key[1].".id = :".$key;
                $innerJoins[] = [$string1, $string2, $string3, $key, $value];

                // $query
                //     ->innerJoin($string1, $string2)
                //     ->andWhere($string3)
                //     ->setParameter('filter', $value);
                }
                // dump($innerJoins);
                foreach ($innerJoins as $innerJoin) {
                    $query->innerJoin($innerJoin[0], $innerJoin[1]);
                }
                foreach ($innerJoins as $innerJoin) {
                    $query->andWhere($innerJoin[2]);
                }
                foreach ($innerJoins as $innerJoin) {
                    $query->setParameter($innerJoin[3], $innerJoin[4]);
                }
                    // $query->setParameters($parameters);
            }

        // if ($speciality != '') {
        //     $query
        //         ->innerJoin('m.speciality', 's')
        //         ->andWhere('s.name = :speciality')
        //         ->setParameter('speciality', $speciality);
        // }

        // if ($filter === 'disabled') {
        //     $query->andWhere('u.isActivated = false');
        // }

        if ($querySearch != null) {
            $query->andWhere('m.codeName LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('m.codeName');
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    //    /**
    //     * @return Mission[] Returns an array of Mission objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Mission
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
