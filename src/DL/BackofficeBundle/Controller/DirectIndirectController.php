<?php

namespace DL\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity\Mlm as Mlm;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;

class DirectIndirectController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/pt/{id}/{year}/{code}")
     * @param Request $request
     * @Rest\View()
     */
    public function getdirectbymonthAction(Request $request)
    {
        $code = $request->get('code');
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')
            ->findOneBy(array('code'=>$code));
        $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>$restresult->getId()));
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
        $dated = new \DateTime($year . '-' . $month . '-' . '01 01:00:00');
        $mlms = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->directbymonth($dated,$date,$restresult->getCode());
        $direct =array();
        for($c=0;$c<count($mlms);$c++){
            $restresult1 = $this->getDoctrine()->getRepository('DLUserBundle:User')
                ->find($mlms[$c]['idpartenaire']);
            array_push($direct,$restresult1);
        }
        return $restresult1;
    }

    /**
     * @Rest\Get("/ind/{id}/{year}/{code}")
     * @param Request $request
     * @Rest\View()
     */
    public function getidirectbymonthAction(Request $request)
    {
        $code = $request->get('code');
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')
            ->find($code);
            //->findOneBy(array('code'=>$code));
        $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>$restresult->getId()));
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
        $dated = new \DateTime($year . '-' . $month . '-' . '01 01:00:00');

        if(!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())){
            $chield=array();
            $fchield=array();
            array_push($chield,$mlm->getCodegauche());
            array_push($chield,$mlm->getCodedroite());
            for($c=0;$c<count($chield);$c++){
                $a = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->info($chield[$c]);
                $b = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->getmlm($a);
                if(!empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(!empty($b->getCodegauche()) && empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                else{
                    var_dump('aaa');
                }
            }

        }
        if(!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())){
            $chield=array();
            array_push($chield,$mlm->getCodegauche());
            for($c=0;$c<count($chield);$c++){
                $a = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->info($chield[$c]);
                $b = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->getmlm($a);
                if(!empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(!empty($b->getCodegauche()) && empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                else{
                    var_dump('aaa');
                }
            }

        }
        if(empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())){
            $chield=array();
            array_push($chield,$mlm->getCodedroite());
            for($c=0;$c<count($chield);$c++){
                $a = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->info($chield[$c]);
                $b = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->getmlm($a);
                if(!empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(!empty($b->getCodegauche()) && empty($b->getCodedroite())){
                    array_push($chield,$b->getCodegauche());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                elseif(empty($b->getCodegauche()) && !empty($b->getCodedroite())){
                    array_push($chield,$b->getCodedroite());
                    if($b->getDateaffectation()>=$dated && $b->getDateaffectation()<=$date){
                        array_push($fchield,$b);
                    }
                }
                else{
                    var_dump('aaa');
                }
            }

        }
        var_dump(count($fchield));die();
    }
}
