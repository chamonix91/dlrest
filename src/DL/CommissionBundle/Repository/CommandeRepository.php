<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 14/01/2018
 * Time: 12:31
 */

namespace DL\CommissionBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CommandeRepository extends EntityRepository
{
    public function Calcanciencom($i)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('commande');
        $qb->from('DLBackofficeBundle:Revenu','revenu');
        // $qb->from('DLGlobalBundle:DreamlifePartnerSale','sale');
        $qb->where('revenu.idpartenaire = :name')
            ->andWhere('revenu.type LIKE  :indirect');
        $qb->setParameter('name', $i);
        $qb->setParameter('indirect', 'indirect');
        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
    }
}