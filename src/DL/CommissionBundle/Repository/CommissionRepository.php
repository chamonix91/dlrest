<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 29/12/2017
 * Time: 11:59
 */
namespace DL\CommissionBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommissionRepository extends EntityRepository
{
    public function Calcanciencom($i)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('Sum(revenu.montant)');
        $qb->from('DLBackofficeBundle:Revenu','revenu');
       // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('revenu.idpartenaire = :name')
            ->andWhere('revenu.type LIKE  :indirect');
        $qb->setParameter('name', $i);
        $qb->setParameter('indirect', 'indirect');
        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
    public function Calcanciendirect($i)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('Sum(revenu.montant)');
        $qb->from('DLBackofficeBundle:Revenu','revenu');
        // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('revenu.idpartenaire = :name')
            ->andWhere('revenu.type LIKE  :indirect');
        $qb->setParameter('name', $i);
        $qb->setParameter('indirect', 'direct');
        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
    public function getcommision($i, $j)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('revenu');
        $qb->from('DLBackofficeBundle:Revenu','revenu');
        //$qb->where('revenu.date <= :name');
        $qb->where('revenu.date BETWEEN :namei AND :name');
        $qb->setParameter('name', $i);
        $qb->setParameter('namei', $j);
        $count = $qb->getQuery()->getResult();
        return $count;
    }

}