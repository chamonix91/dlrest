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
use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;

class CommissionController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function getleftpartner($code)
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

    public function getmyinfo($id)
    {
        $user = $this->get('doctrine.orm.entity_manager')
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

        $neud = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);


        return $neud->getMontant();
    }

    /**
     * @Rest\Get("/commission/{id}/{year}")
     * @param Request $request
     * @Rest\View()
     */
    public function getearnbymonthAction(Request $request)
    {
        $startMonth = new \DateTime('2018' . '-' . '01' . '-01 23:59:59');
        $month = $request->get('id');
        $year = $request->get('year');
        if ($month == 2) {
            if ($year % 4 == 0) {
                $day = 29;
            } else {
                $day = 28;
            }
        } elseif ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            $day = 31;
        } else {
            $day = 30;
        }
        $date = new \DateTime($year . '-' . $month . '-' . $day . ' 23:23:59');
        //$date = new \DateTime($year . '-' . $month . '-' . $day . '30 23:59:59');
        $dated = new \DateTime($year . '-' . $month . '-' . '01 01:00:00');
       /* var_dump($date);
        var_dump($dated);
        die();*/
        /***prerequit***/



        $comarray = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Revenu')
//            ->findAll();
            ->getcommision($date, $dated);
//        var_dump(count($comarray));die();
        $lcp = array();
        for($f=0;$f<count($comarray);$f++){
            if($comarray[$f]['commission']>0){
                if($comarray[$f]['commission']<
                    $this->getmypack($this->getmymlm($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond()){
                    $lcp[] = [
                        'nom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getNom(),
                        'mail' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getEmail(),
                        'prenom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getPrenom(),
                        'cin' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getCin(),
                        'rib' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getRib(),
                        'chiffre' => $comarray[$f]['commission'],
                        //'pack' => $this->getmypack($this->getmlmbyid($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond(),
                    ];}
                else{
                    $lcp[] = [
                        'nom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getNom(),
                        'mail' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getEmail(),
                        'prenom' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getPrenom(),
                        'cin' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getCin(),
                        'rib' => $this->getmyinfo($comarray[$f]['rev']->getIdpartenaire())->getRib(),
                        //'chiffre' => $comarray[$f]['commission'],
                        'chiffre' => $this->getmypack($this->getmymlm($comarray[$f]['rev']->getIdpartenaire())->getPaqueid())->getPlafond(),
                    ];
                }
            }
        }


        return $lcp;

    }
    function getmyparent($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($i);
        return $mlm;
    }
    function getmydirect($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($i);
        return $mlm;
    }
    function getmymlm($i){
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
