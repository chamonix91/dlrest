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
    public function directbymonth($d1,$d2,$code){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('mlm.idpartenaire');
        $qb->from('DLBackofficeBundle:Mlm','mlm');
        // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('mlm.codedirect = :name')
            ->andWhere('mlm.dateaffectation BETWEEN :namei AND :names');
        $qb->setParameter('name', $code);
        $qb->setParameter('namei', $d1);
        $qb->setParameter('names', $d2);
        $count = $qb->getQuery()->getResult();
        return $count;
    }
    public function info($code){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('user.id');
        $qb->from('DLUserBundle:User','user');
        $qb->where('user.code = :name');
        $qb->setParameter('name', $code);
        $count = $qb->getQuery()->getSingleResult();
        return $count;
    }
    public function getmlm($id){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('mlm');
        $qb->from('DLBackofficeBundle:Mlm','mlm');
        $qb->where('mlm.idpartenaire = :name');
        $qb->setParameter('name', $id);
        $count = $qb->getQuery()->getSingleResult();
        return $count;
    }
    public function cori(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('mlm.idpartenaire');
        $qb->from('DLBackofficeBundle:Mlm','mlm');
        // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('mlm.datecreation > :name');
        $qb->setParameter('name', "2018-06-15 00:00:01");
        $count = $qb->getQuery()->getResult();
        return $count;
    }

}