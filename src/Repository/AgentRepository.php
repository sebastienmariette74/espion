<?php

namespace App\Repository;

use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Agent>
 *
 * @method Agent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agent[]    findAll()
 * @method Agent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }

    public function save(Agent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Agent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Agent[] Returns an array of Agent objects
    */
   public function findAllNationality(): array
   {
       return $this->createQueryBuilder('a')
            ->select('a.id, a.firstname, a.lastname, a.dateOfBirth, a.code, n.nationality')
            ->innerJoin('a.nationality', 'n')
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Agent[] Returns an array of Agent objects
    */
   public function findAllByCountries($countries): array
   {
       return $this->createQueryBuilder('a')
       ->innerJoin('a.country', 'c')
       ->where('c.name NOT IN (:countries)')
            ->setParameter('countries', $countries)
           ->getQuery()
           ->getResult()
       ;
   }

   public function getPaginated($page, $limit, $filters, $querySearch)
    {
        $query = $this->createQueryBuilder('a')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ->orderBy('a.code');

        if ($querySearch != null) {
            $query->andWhere('a.code LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('a.code');
        }

        return $query->getQuery()->getResult();
    }

    public function getTotal($filters, $querySearch)
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)');

        if ($querySearch != null) {
            $query->andWhere('a.code LIKE :query')
                ->setParameter('query', '%' . $querySearch . '%')
                ->orderBy('a.code');
        }

        return $query->getQuery()->getSingleScalarResult();
    }

}
