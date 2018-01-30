<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 05/01/2018
 * Time: 16:51
 */

namespace DLUserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class LoginRepository extends EntityRepository
{
    public function login($email , $password)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('r')
            ->from('DLUserBundle:User', 'r')
            ->where( 'r.email =:email')
            ->andWhere('r.plainPassword =:password')
            ->setParameter('email', $email)
            ->setParameter('password', $password);
        $query = $qb->getQuery();
        $user = $query->getResult();
        return $user;

    }

}