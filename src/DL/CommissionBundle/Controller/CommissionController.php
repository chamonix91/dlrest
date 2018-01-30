<?php

namespace DL\CommissionBundle\Controller;

use DL\BackofficeBundle \Entity\Revenu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use DL\UserBundle\Entity\User;

class CommissionController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function getleftpartner($code){
        $user  = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if($user){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($user->getId());
        if($mlm != Null)
        return $mlm;
        else
            return Null;
        }
        else{
            return Null;
        }
    }
    public function getrightpartner($code)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->get('doctrine.orm.entity_manager')
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
    public function getmyinfo($id){
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);
        return $user;
    }
   public function cmp($a, $b)
    {
        return ($a->getDateaffectation()> $b->getDateaffectation());
    }
    public  function getmycommande($i){
        var_dump($i);
        $neud = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);
        //var_dump($neud->getIdproduit());
        $produit = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:Produit')
            ->find($neud->getIdproduit());
        return $produit->getPrix();
    }

    /**
     * @Rest\Get("/commission/{id}/{year}")
     * @param Request $request
     * @Rest\View()
     */
    public function getearnbymonthAction(Request $request){
        $startMonth = new \DateTime('2018' . '-' . '01' . '-01 23:59:59');
        $month = $request->get('id');
        $year = $request->get('year');
        if($month==2){
            if($year % 4 ==0){
                $day=29;
            }else{
                $day=28;
            }
        }
        elseif ($month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12){
            $day=31;
        }else{
            $day = 30;
        }
        $date = new \DateTime($year. '-' . $month . '-' . $day .' 23:59:59');
        $dated = new \DateTime($year. '-' . $month . '-' . '01 01:00:00');
        /***prerequit***/
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();
        //$this->findBy(array(), array('username' => 'ASC'));
        /***recherche***/
        $mydirect = array();
        $lchield = array();
        $rchield = array();
        for ($c = 0; $c < count($mlms); $c++) {
          //  var_dump($mlms[$c]->getId());

            if ($mlms[$c]->getaffectation() == 1 && $mlms[$c]->getcodegauche()!='NULL' && $mlms[$c]->getcodedroite()!='NULL') {
                if(!empty($this->getleftpartner($mlms[$c]->getcodegauche()))&&
                    $this->getrightpartner($mlms[$c]->getcodedroite())) {
                    if ($mlms[$c]->getcodegauche() != 'NULL' && $mlms[$c]->getcodedroite() != 'NULL'
                        && $this->getleftpartner($mlms[$c]->getcodegauche())->getAffectation() == 1 &&
                        $this->getrightpartner($mlms[$c]->getcodedroite())->getaffectation() == 1) {
                        array_push($lchield, $this->getleftpartner($mlms[$c]->getcodegauche()));
                        array_push($rchield, $this->getrightpartner($mlms[$c]->getcodedroite()));
                    }
                }
                //var_dump($rchield[0]->getCodedirect());die();

                for ($i = 0; $i < count($lchield); $i++) {

                        if ($lchield[$i]->getCodedirect() == $this->getmyinfo($mlms[$c]->getIdpartenaire())->getCode()) {
                            array_push($mydirect, $lchield[$i]);
                        }

                    if ($lchield[$i]->getcodegauche()!='NULL' && $lchield[$i]->getcodedroite()!='NULL'
                    ) {
                        if(!empty($this->getleftpartner($lchield[$i]->getcodegauche()))&&
                            !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                            array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                            array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                        }
                    } elseif ($lchield[$i]->getcodegauche()!='NULL' && $lchield[$i]->getcodedroite()=='NULL' ) {
                        if(!empty($this->getleftpartner($lchield[$i]->getcodegauche()))) {
                        array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));}
                    } elseif ($lchield[$i]->getcodegauche()=='NULL' && $lchield[$i]->getcodedroite()!='NULL') {
                        if(
                            !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                        array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));}
                    }

                }//fin boucle lchield

                for ($i = 0; $i < count($rchield); $i++) {

                    if($rchield[$i]->getCodedirect()==
                        $this->getmyinfo($mlms[$c]->getIdpartenaire())->getCode()){
                        array_push($mydirect, $rchield[$i]);
                    }
                    if ($rchield[$i]->getcodegauche()!='NULL' && !($rchield[$i]->getcodedroite()!='NULL')) {
                        if(!empty($this->getleftpartner($rchield[$i]->getcodegauche()))&&
                        !empty($this->getrightpartner($rchield[$i]->getcodedroite()))){
                        array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                        array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));}

                    } elseif ($rchield[$i]->getcodegauche()!='NULL' && !($rchield[$i]->getcodedroite()=='NULL')) {
                        if(!empty($this->getleftpartner($rchield[$i]->getcodegauche()))) {
                            array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                        }
                    } elseif ($rchield[$i]->getcodegauche()=='NULL' && !($rchield[$i]->getcodedroite()!='NULL')) {
                        if(!empty($this->getrightpartner($rchield[$i]->getcodedroite()))) {
                            array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));
                        }
                    }

                }//fin boucle rchield
                /*
                 * houni na7iw eli validation mté3hom 9bal janvier
                 */

                $n =count($lchield);
                $flchield = array();
                $frchield = array();
                for ($i = 0; $i < count($rchield); $i++) {
                    if ($rchield[$i]->getDateaffectation()>$startMonth) {
                        array_push($frchield,$rchield[$i]);
                    }
                }
                for ($i = 0; $i < $n; $i++) {
                    if ($lchield[$i]->getDateaffectation()>$startMonth) {
                       // unset($lchield[$i]);
                        array_push($flchield,$lchield[$i]);
                    }
                }
                /*
                 * delete inactive partner
                 */
                $lchield = array();
                $rchield = array();
                for ($i = 0; $i < count($frchield); $i++) {
                    if (!$frchield[$i]->getAffectation()) {
                        array_push($rrchield,$frchield[$i]);
                    }
                }
                for ($i = 0; $i < count($flchield); $i++) {
                    if (!$flchield[$i]->getAffectation()) {
                        array_push($lchield,$flchield[$i]);
                    }
                }
                //var_dump('heelo'); die();
                /*
                 * sort tables chields
                 */
                usort($lchield, array($this, "cmp"));
                usort($rchield, array($this, "cmp"));
                /*
                 * ancienne commmission indirect
                 */
                $ac = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('DLBackofficeBundle:Revenu')
                    ->Calcanciencom($mlms[$c]->getIdpartenaire());
                /*
                 * ancienne commision direct
                 */
                $acd = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('DLBackofficeBundle:Revenu')
                    ->Calcanciendirect($mlms[$c]->getIdpartenaire());
                /*
                 * calcule commission direct
                 */
                $totacommissiondirect =0;
                for ($j = 0; $j < count($mydirect) ; $j++) {
                    $f = $this->getmycommande($mydirect[$j]->getIdpartenaire());
                    $totacommissiondirect = $totacommissiondirect +$f;
                }
                /*
                 * calcule full commission indirect
                 */

                if (count($lchield) > count($rchield)) {
                    $totalcommission = 0;
                    for ($j = 0; $j < count($rchield) - (count($rchield) % 2); $j++) {
                        $x = $this->getmycommande($rchield[$j]->getIdpartenaire()) +
                            $this->getmycommande($lchield[$j]->getIdpartenaire());
                        $totalcommission = $totalcommission + $x;
                    }


                } else {
                    $totalcommission = 0;
                    for ($j = 0; $j < count($lchield) - (count($lchield) % 2); $j++) {
                        $x = $this->getmycommande($rchield[$j]->getIdpartenaire())
                            + $this->getmycommande($lchield[$j]->getIdpartenaire());
                        $totalcommission = $totalcommission + $x;
                    }

                }
                //var_dump($mydirect);die();
                $lchield = array();
                $rchield = array();
                $mydirect = array();

                $commissionindirect = $totalcommission * 0.05;
                $commissionindirect = $commissionindirect - $ac;
                $commissiondirect = $totacommissiondirect *0.1;
                $commissiondirect = $commissiondirect -$acd;


                $revenue = new Revenu();
                $revenue->setIddue(1);
                $revenue->setIdpartenaire($mlms[$c]->getIdpartenaire());
                $revenue->setType('indirect');
                $revenue->setDate(new \DateTime("now"));
                $revenue->setMontant($commissionindirect);
                $em = $this->getDoctrine()->getManager();
                $em->persist($revenue);
                $em->flush();
                $revenued = new Revenu();
                $revenued->setIddue(1);
                $revenued->setIdpartenaire($mlms[$c]->getIdpartenaire());
                $revenued->setType('direct');
                $revenued->setDate(new \DateTime("now"));
                $revenued->setMontant($commissiondirect);
                $em = $this->getDoctrine()->getManager();
                $em->persist($revenued);
                $em->flush();
            }//fin test ma3ni bel amér activé ou nn
        }//end boucle sur users

        $comarray = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Revenu')
            ->getcommision($date, $dated);
        $lcp = array();
        for($f=0;$f<count($comarray);$f++){
            if($comarray[$f]['commission']>0){
                if($comarray[$f]['commission']<
                    $this->getmypack($this->getmlmbyid($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond()){
                    $lcp[] = [
                        'nom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getNom(),
                        'prenom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getPrenom(),
                        'cin' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getCin(),
                        'rib' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getRib(),
                        'chiffre' => $comarray[$f]['commission'],
                        //'pack' => $this->getmypack($this->getmlmbyid($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond(),
                    ];}
                else{
                    $lcp[] = [
                        'nom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getNom(),
                        'prenom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getPrenom(),
                        'cin' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getCin(),
                        'rib' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getRib(),
                        //'chiffre' => $comarray[$f]['commission'],
                        'chiffre' => $this->getmypack($this->getmlmbyid($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond(),
                    ];
                }
            }
        }
        return $lcp;
    }
    function getinfobyid($i){
        $comarray = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($i);
        return $comarray;
    }
    function getmlmbyid($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($i);
        return $mlm;
    }
    function getmypack($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Pack')
            ->find($i);
        return $mlm;
    }
}
