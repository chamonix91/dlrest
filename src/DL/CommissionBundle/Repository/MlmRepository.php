<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/12/2017
 * Time: 15:30
 */

namespace DL\CommissionBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MlmRepository extends EntityRepository
{
    public function FilterActive()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('mlm');
        $qb->from('DLBackofficeBundle:Mlm','mlm');
        // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('mlm.affectation = :name');
        $qb->setParameter('name', 1);
        $count = $qb->getQuery()->getResult();
        return $count;
    }

}