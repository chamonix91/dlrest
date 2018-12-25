<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 14/02/2018
 * Time: 15:35
 */
namespace DL\CommissionBundle\Service;
use DL\BackofficeBundle \Entity\Revenu;
use DL\CommissionBundle\Command\leftcommandCommand;
use DL\CommissionBundle\Controller\TreeController;
use DL\UserBundle\DLUserBundle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Request;
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
       // var_dump($i);
        $neud = $this->em
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);

        if(empty($neud)){
            return 600;
        }else {
            return $neud->getMontant();
        }
    }
    function getmypack($i){
        $mlm = $this->em
            ->getRepository('DLBackofficeBundle:Pack')
            ->find($i);
        return $mlm;
    }
    //public function testing($io){
    public function testing($dispropcom , $io){
       // var_dump($io);

        $this->em->getConfiguration()->setSQLLogger(null);
        $mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire((int)$io);
        /*
        $mlms = $this->em
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();
        $mlm=$this->em->getRepository('DLBackofficeBundle:Mlm')->findOneByidpartenaire((int)$io);
        $dir=$this->em->getRepository('DLUserBundle:User')->findOneBycode($mlm->getCodedirect());
        $revenue = new Revenu();
        $revenue->setIddue(1);
        $revenue->setIdpartenaire($dir->getId());
        $revenue->setType('jondirect');
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
//houni
        */
        $lchield = array();
        $rchield = array();

        //for ($c = 16; $c < 17; $c++) {
       // for ($c = 0; $c < count($dispropcom); $c++) {
            $test = false;
            if (!empty($this->getleftpartner($dispropcom->getcodegauche())) &&
                $this->getrightpartner($dispropcom->getcodedroite())) {
                /*if ($dispropcom->getcodegauche() != 'NULL' && $dispropcom->getcodedroite() != 'NULL'
                    && $this->getleftpartner($dispropcom->getcodegauche())->getAffectation() == 1 &&
                    $this->getrightpartner($dispropcom->getcodedroite())->getaffectation() == 1) {*/
                if ($dispropcom->getcodegauche() != 'NULL' && $dispropcom->getcodedroite() != 'NULL' &&
                    $dispropcom->getaffectation() == 1) {
                    $test = true;
                    array_push($lchield, $this->getleftpartner($dispropcom->getcodegauche()));
                    array_push($rchield, $this->getrightpartner($dispropcom->getcodedroite()));

                }
            }
            //gauche droite
            if ($test) {


                for ($i = 0; $i < count($rchield); $i++) {

                    if($i % 500 == 0 ){
                         sleep ( 5 );
                    }
                    if($rchield[$i]->getId()==$mlm->getId()){
                        break;
                    }

                    if (!empty($rchield[$i]) && $rchield[$i]->getIdpartenaire() != $mlm->getIdpartenaire()) {

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
                }//fin boucle rchield


                for ($i = 0; $i < count($lchield); $i++) {
                    if($i % 500 == 0 ){
                        sleep ( 5 );
                    }
                    if($lchield[$i]->getId()==$mlm->getId()){
                        break;
                    }
                    if (!empty($lchield[$i]) && $lchield[$i]->getIdpartenaire() != $mlm->getIdpartenaire()) {

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
            $t=0;
            for($e=0;$e<count($lchield);$e++){
                if($mlm->getId()==$lchield[$e]->getId()){
                   $t=1;
                   break;
                }
            }
            /*if(array_search($mlm,$lchield)!=false){
                $t=0;
            }*/
            $t1=0;
        for($e=0;$e<count($rchield);$e++){
            if($mlm->getId()==$rchield[$e]->getId()){
                $t1=1;
                break;
            }
        }
            /*if(array_search($mlm,$rchield)!=false){
                $t1=0;
            }*/



            if($t==1){
            if( count($lchield)<= count($rchield)){
                //if(array_search($mlm,$lchield)%2==1){
                //var_dump('a');
                if(count($lchield) %2==0){
                    $y=array_search($mlm,$lchield);
                    $x = $this->getmycommande($rchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($rchield[$y-1]->getIdpartenaire())+
                        $this->getmycommande($lchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire());
                   $x=$x *( $this->getmypack($dispropcom->getPaqueid())->getCoef()/100);
                    $x=$x*0.85;
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                        $this->em->persist($revenued);
                        $this->em->flush();
                }
            }
            else{

                $jdod=array();
                $gdom=array();
                for($j=0;$j<count($lchield);$j++){
                    if($lchield[$j]->getDateaffectation()>'2017-12-31 00:00:00'){
                        array_push($jdod,$lchield[$j]);
                    }
                }
                for($j=0;$j<count($rchield);$j++){
                    if($rchield[$j]->getDateaffectation()<='2017-12-31 00:00:00'){
                        array_push($gdom,$rchield[$j]);
                    }
                }
               // var_dump(count($gdom));
                //var_dump(count($jdod));die();
                if(count($jdod)<=count($gdom) && count($jdod) %2==0 && count($gdom)>0){
                    $y=array_search($mlm,$jdod);
                    $x = $this->getmycommande($jdod[$y]->getIdpartenaire()) +
                        $this->getmycommande($jdod[$y-1]->getIdpartenaire())+
                        $this->getmycommande($gdom[$y]->getIdpartenaire()) +
                        $this->getmycommande($gdom[$y-1]->getIdpartenaire());
                    $x=$x*0.85;
                    $x=$x *( $this->getmypack($dispropcom->getPaqueid())->getCoef()/100);
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                    $this->em->persist($revenued);
                    $this->em->flush();
                }
            }
            }
            else{
            if( count($rchield)<=count($lchield)){
                //if(array_search($mlm,$rchield)%2==1){
               // var_dump('b');
                if(count($rchield) %2==0){
                    $y=array_search($mlm,$rchield);
                    $x = $this->getmycommande($rchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire())+
                        $this->getmycommande($lchield[$y]->getIdpartenaire()) +
                        $this->getmycommande($lchield[$y-1]->getIdpartenaire());
                    $x=$x*0.85;
                    $x=$x *( $this->getmypack($dispropcom->getPaqueid())->getCoef()/100);
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                    $this->em->persist($revenued);
                    $this->em->flush();
                }
            }
            else{
                //var_dump('rrrkkk');die();
                $jdod=array();
                $gdom=array();
                for($j=0;$j<count($rchield);$j++){
                    if($rchield[$j]->getDateaffectation()>'2017-12-31 00:00:00'){
                        array_push($jdod,$rchield[$j]);
                    }
                }
                for($j=0;$j<count($lchield);$j++){
                    if($lchield[$j]->getDateaffectation()<='2017-12-31 00:00:00'){
                        array_push($gdom,$lchield[$j]);
                    }
                }
                if(count($jdod)<=count($gdom) && count($jdod) %2==0 && count($gdom)>0){
                    $y=array_search($mlm,$jdod);
                    $x = $this->getmycommande($jdod[$y]->getIdpartenaire()) +
                        $this->getmycommande($jdod[$y-1]->getIdpartenaire())+
                        $this->getmycommande($gdom[$y]->getIdpartenaire()) +
                        $this->getmycommande($gdom[$y-1]->getIdpartenaire());
                    $x=$x*0.85;
                    $x=$x *( $this->getmypack($dispropcom->getPaqueid())->getCoef()/100);
                    $revenued = new Revenu();
                    $revenued->setIddue(1);
                    $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
                    $revenued->setType('indirect');
                    $revenued->setDate(new \DateTime("now"));
                    $revenued->setMontant($x);
                    $this->em->persist($revenued);
                    $this->em->flush();
                }
            }
            }

   //}//fin

        $revenued = new Revenu();
        $revenued->setIddue(count($lchield));
        $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
        $revenued->setType('wfééééé');
        $revenued->setDate(new \DateTime("now"));
        $revenued->setMontant(count($rchield));
        /*$this->em->persist($revenued);
        $this->em->flush();*/
       /* $revenued = new Revenu();
        $revenued->setIddue(1);
        $revenued->setIdpartenaire($dispropcom->getIdpartenaire());
        $revenued->setType('amara');
        $revenued->setDate(new \DateTime("now"));
        $revenued->setMontant(1);
        $this->em->persist($revenued);
        $this->em->flush();
*/
    }
}