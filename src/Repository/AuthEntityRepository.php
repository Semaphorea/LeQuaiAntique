<?php

namespace App\Repository;

use App\Entity\AuthEntity;
use App\Entity\Model\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;





/**
 * @extends ServiceEntityRepository<AuthEntity>
 *
 * @method AuthEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthEntity|null findOneByEmail(array $criteria, array $orderBy = null)
 * @method AuthEntity[]    findAll()
 * @method AuthEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthEntityRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthEntity::class);
    }

    public function save(AuthEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AuthEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof AuthEntity) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

//    /**
//     * @return AuthEntity[] Returns an array of AuthEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

   
  /**
   * findOneByEmail
   * return AuthEntity
   */
   public function findOneByEmail($value): ?AuthEntity
   {
  
    $query=$this->createQueryBuilder('a') 
    ->andWhere('a.email = :val')
    ->setParameter('val', $value)
    ->getQuery() 
    ->getOneOrNullResult()   
    ;
        var_export($query->getQuery()->getParameters());
    //    var_export($query->getQuery()->getSql());
       return $query; 
   }
   
   /**
    * findOneByUsernameDQL  
    * @Param : username   
    * return AuthEntity
    */
   public function findOneByUsernameDQL($username):? AuthEntity    
   { 
 
       $query=$this->getEntityManager()->createQuery('
          select e  from App\Entity\AuthEntity e where e.username=\''.$username.'\'') ; 
       $res=$query->getOneOrNullResult();
       
     return $res;      
   }
  

    /**
    * findOneByEmailDQL  
    * @Param : email   
    * return AuthEntity
    */
    public function findOneByEmailDQL($email):? AuthEntity    
    { 
       
        $query=$this->getEntityManager()->createQuery('
        select e  from App\Entity\AuthEntity e where e.email=\''.$email.'\'') ; 
        $res=$query->getOneOrNullResult();
    
      return $res;      
    }
}
