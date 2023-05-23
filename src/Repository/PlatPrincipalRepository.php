<?php

namespace App\Repository;

use App\Entity\PlatPrincipal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlatPrincipal>
 *
 * @method PlatPrincipal|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatPrincipal|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatPrincipal[]    findAll()
 * @method PlatPrincipal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatPrincipalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatPrincipal::class);
    }

    public function save(PlatPrincipal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlatPrincipal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlatPrincipal[] Returns an array of PlatPrincipal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlatPrincipal
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


/**
 * Function findAllDQL
 * Return un tableau avec l'ensemble des colonnes de l'entité joint à la table photo
 */
public function findAllDQL($entity):? array    
    {  
        $query=$this->getEntityManager()->createQuery(
            'select e.id, e.titre,e.description,e.prix,p.binaryfile from '.$entity.' e JOIN App\Entity\Photo p  where e.photo=p.id ' ) ; 
        $res=$query->getResult();      
      return $res;    
  
    }
}
