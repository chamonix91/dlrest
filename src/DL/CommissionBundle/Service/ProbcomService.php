<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 15/04/2018
 * Time: 23:29
 */

namespace DL\CommissionBundle\Service;
use DL\BackofficeBundle \Entity\Revenu;
use DL\CommissionBundle\Controller\TreeController;
use DL\UserBundle\DLUserBundle;
use Doctrine\ORM\EntityManager;

class ProbcomService
{
    /** @var EntityManager */
    private $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function getmycommande($i)
    {

        $neud = $this->em
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);

        if(empty($neud)){
            return 200;
        }else{
        return $neud->getMontant();}
    }
    public function getlawezem($ids){
        $mlms = $this->em
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();
        //var_dump($ids);
        $mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire((int)$ids);
        $dir=$this->em->getRepository('DLUserBundle:User')->findOneBycode($mlm->getCodedirect());
        $revenue = new Revenu();
        $revenue->setIddue(1);
        $revenue->setIdpartenaire($dir->getId());
        $revenue->setType('direct');
        $revenue->setDate(new \DateTime("now"));
        $revenue->setMontant($this->getmycommande($mlm->getIdpartenaire())*0.1);
        $this->em->persist($revenue);
        $this->em->flush();
        $uplines=array();
        $probcom=array();
        array_push($uplines,$mlm);
        $x=count($uplines);
        for($c=0;$c<$x;$c++){
            //var_dump($uplines[$c]->getIdpartenaire());
            $user=$this->em->getRepository('DLUserBundle:User')->find($uplines[$c]->getIdpartenaire());
            if($user->getId()==706 ||$user->getId()== 1511 || $user->getId()== 9242
            || $user->getId()== 2056 || $user->getId()== 1330 || $user->getId()== 1095
                || $user->getId()== 9050|| $user->getId()== 145|| $user->getId()== 2306
                || $user->getId()== 2259
                || $user->getId()== 496 ){
                break;
            }
            //$mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire($io);
            for($j=0;$j<count($mlms);$j++){

                if(($mlms[$j]->getCodegauche()==$user->getCode() || $mlms[$j]->getCodedroite()==$user->getCode() &&
                    !array_search($mlms[$j], $uplines))
                ){
                    array_push($uplines,$mlms[$j]);
                    $x=$x+1;
                    if($mlms[$j]->getAffectation()==1){
                        if( !empty($mlms[$j]->getCodegauche()) && !empty($mlms[$j]->getCodedroite()) && !array_search($mlms[$j], $probcom)){
                            array_push($probcom,$mlms[$j]);

                        }
                    }
                }
            }
        }

        $dispropcom=array_unique($probcom, SORT_REGULAR);
return $dispropcom;
    }
}