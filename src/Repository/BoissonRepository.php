<?php

namespace App\Repository;

use App\Entity\Boisson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boisson>
 *
 * @method Boisson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boisson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boisson[]    findAll()
 * @method Boisson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoissonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boisson::class);
    }

    public function save(Boisson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Boisson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Boisson[] Returns an array of Boisson objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Boisson
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
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

/**
 * Function findByIdDQL
 * Return un tableau avec l'ensemble des colonnes de l'entité joint à la table photo
 */
public function findByIdDQL($entity,$id):? array    
    {  
        $query=$this->getEntityManager()->createQuery(
            'select e.id, e.titre,e.description,e.prix,p.binaryfile from '.$entity.' e JOIN App\Entity\Photo p  where e.photo=p.id and e.id='.$id) ;  
        $res=$query->getOneOrNullResult();       
      return $res;    

    }    

}