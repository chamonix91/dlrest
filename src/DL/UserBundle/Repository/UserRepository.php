<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 01/01/2018
 * Time: 11:32
 */

namespace DLUserBundle\Repository;


use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{

    public function findOneByEmail($email)
    {
        /*$em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('c')
            ->where('c.email = :email')
            ->setParameter('email', $email)
            ->getQuery();
        return $q->getResult(); // will return only one result or null 'getResult' will return a collection*/




        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('r')
            ->from('DLUserBundle:User', 'r')
            ->where( 'r.email =:email')
            ->setParameter('email', $email);
        $query = $qb->getQuery();
        $reservation = $query->getResult();
        return $reservation;

    }

}