<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 14/02/2018
 * Time: 15:35
 */
namespace DL\CommissionBundle\Service;
use DL\BackofficeBundle \Entity\Revenu;
use DL\UserBundle\DLUserBundle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;

class TestService
{
    /** @var EntityManager */
    private $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function getleftpartner($code)
    {
        $user = $this->em
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->em
                ->getRepository('DLBackofficeBundle:Mlm')
                ->findOneByidpartenaire($user->getId());
            if ($mlm != Null)
                return $mlm;
            else
                return Null;
        } else {
            return Null;
        }
    }

    public function getrightpartner($code)
    {
        $user = $this->em
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->em
                ->getRepository('DLBackofficeBundle:Mlm')
                ->findOneByidpartenaire($user->getId());
            if ($mlm != Null)
                return $mlm;
            else
                return Null;
        } else {
            return Null;
        }
    }

    public function getmyinfo($id)
    {
        $user = $this->em
            ->getRepository('DLUserBundle:User')
            ->find($id);
        return $user;
    }

    public function cmp($a, $b)
    {
        return ($a->getDateaffectation() > $b->getDateaffectation());
    }

    public function getmycommande($i)
    {

        $neud = $this->em
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);


        return $neud->getMontant();
    }
    function getmypack($i){
        $mlm = $this->em
            ->getRepository('DLBackofficeBundle:Pack')
            ->find($i);
        return $mlm;
    }
    public function testing($io){
        $mlms = $this->em
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();
        $mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire((int)$io);
        $dir=$this->em->getRepository('DLUserBundle:User')->findOneBycode($mlm->getCodedirect());
        $revenue = new Revenu();
        $revenue->setIddue(1);
        $revenue->setIdpartenaire($dir->getId());
        $revenue->setType('indirect');
        $revenue->setDate(new \DateTime("now"));
        $revenue->setMontant($this->getmycommande($mlm->getIdpartenaire())*0.1);
        $this->em->persist($revenue);
        $this->em->flush();
        $uplines=array();
        $probcom=array();
        array_push($uplines,$mlm);
        $x=count($uplines);
        for($c=0;$c<$x;$c++){
            $user=$this->em->getRepository('DLUserBundle:User')->find($uplines[$c]->getIdpartenaire());
            $mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire($io);
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
        $mydirect = array();
        $lchield = array();
        $rchield = array();
        for ($c = 0; $c < count($dispropcom); $c++) {
            $test = false;
            if (!empty($this->getleftpartner($dispropcom[$c]->getcodegauche())) &&
                $this->getrightpartner($dispropcom[$c]->getcodedroite())) {
                if ($dispropcom[$c]->getcodegauche() != 'NULL' && $dispropcom[$c]->getcodedroite() != 'NULL'
                    && $this->getleftpartner($dispropcom[$c]->getcodegauche())->getAffectation() == 1 &&
                    $this->getrightpartner($dispropcom[$c]->getcodedroite())->getaffectation() == 1) {
                    $test = true;
                    array_push($lchield, $this->getleftpartner($dispropcom[$c]->getcodegauche()));
                    array_push($rchield, $this->getrightpartner($dispropcom[$c]->getcodedroite()));

                }
            }

            /****gauche droite**/
            if ($test) {
                for ($i = 0; $i < count($rchield); $i++) {

                    if (!empty($rchield[$i])) {

                        //if ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {
                        if ( !empty($rchield[$i]->getcodegauche()) && !empty($rchield[$i]->getcodedroite())) {
                            if (!empty($this->getleftpartner($rchield[$i]->getcodegauche())) &&
                                !empty($this->getrightpartner($rchield[$i]->getcodedroite()))) {
                                array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                                array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));
                            }

                        //} elseif ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() == 'NULL')) {
                        } elseif ( !empty($rchield[$i]->getcodegauche()) && empty($rchield[$i]->getcodedroite())) {
                            if (!empty($this->getleftpartner($rchield[$i]->getcodegauche()))) {
                                array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                            }
                        //} elseif ($rchield[$i]->getcodegauche() == 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {
                        } elseif ( empty($rchield[$i]->getcodegauche()) && !empty($rchield[$i]->getcodedroite())) {
                            if (!empty($this->getrightpartner($rchield[$i]->getcodedroite()))) {
                                array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));
                            }
                        }
                    }
                }//fin boucle rchield*/
                for ($i = 0; $i < count($lchield); $i++) {
                    if (!empty($lchield[$i])) {

                        if ( !empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())
                        ) {
                            if (!empty($this->getleftpartner($lchield[$i]->getcodegauche())) &&
                                !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                                array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                                array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                            }
                        } elseif (!empty($lchield[$i]->getcodegauche()) &&  empty($lchield[$i]->getcodedroite())) {
                            if (!empty($this->getleftpartner($lchield[$i]->getcodegauche()))) {
                                array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                            }
                        } elseif ( empty($lchield[$i]->getcodegauche()) &&  !empty($lchield[$i]->getcodedroite())) {
                            if (
                            !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                                array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                            }
                        }
                    }
                }
            }//fin boucle lchield
            usort($lchield, array($this, "cmp"));
            usort($rchield, array($this, "cmp"));
            $t=1;
            if(!array_search($mlm,$lchield)){
                $t=0;
            }
            $t1=1;
            if(!array_search($mlm,$rchield)){
                $t1=0;
            }
            if($t==1 && count($lchield)<= count($rchield)){
                if(array_search($mlm,$lchield)%2==1){
                    $y=array_search($mlm,$lchield);
                    $x = $this->getmycommande($rchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($rchield[$y-1]->getIdpartenaire())+
                        $this->getmycommande($lchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire());
                   $x=$x *( $this->getmypack($dispropcom[$c]->getPaqueid())->getCoef()/100);
                    $x=$x*0.85;
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom[$c]->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                        $this->em->persist($revenued);
                        $this->em->flush();
                }
            }
            if($t1==1 && count($rchield)<=count($lchield)){
                if(array_search($mlm,$rchield)%2==1){
                    $y=array_search($mlm,$rchield);
                    $x = $this->getmycommande($rchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire())+
                        $this->getmycommande($lchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire());
                    $x=$x*0.85;
                    $x=$x *( $this->getmypack($dispropcom[$c]->getPaqueid())->getCoef()/100);
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom[$c]->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                    $this->em->persist($revenued);
                    $this->em->flush();
                }
            }


        }//fin
        /*$data = new Revenu();
        $data->setMontant(15);
        $data->setIdpartenaire($i);
        $data->setIddue(1);
        $data->setDate(new \DateTime("now"));
        $data->setType('direct');


        $this->em->persist($data);
        $this->em->flush();*/
    }
}