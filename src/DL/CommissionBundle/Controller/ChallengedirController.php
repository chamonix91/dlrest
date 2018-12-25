<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengedirController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function getmyinfo($id)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);
        return $user;
    }
    /**
     * @Rest\Get("/mydirn/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getmydirectAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findby(array('codedirect'=>$user->getCode()));
        for($i=0;$i<count($mlm);$i++){
            $lcp[] = [
                'nomcomplet' => $this->getmyinfo($mlm[$i]->getIdpartenaire())->getNom().' '.
                $this->getmyinfo($mlm[$i]->getIdpartenaire())->getPrenom(),
                'mail' => $this->getmyinfo($mlm[$i]->getIdpartenaire())->getEmail(),
                'id' => $this->getmyinfo($mlm[$i]->getIdpartenaire())->getId(),
                'code' => $this->getmyinfo($mlm[$i]->getIdpartenaire())->getCode(),
                'datevalidation' => $mlm[$i]->getDateaffectation()->format('Y-m'),
            ];
        }
        if(count($mlm)>0)
            return $lcp;
        else
            return null;
    }
    /**
     * @Rest\Get("/myidirn/{id}",name="sssss")
     * @param Request $request
     * @Rest\View()
     */
    public function getmyindirectAction(Request $request)
    {
        $id = $request->get('id');
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);
        $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>$user->getId()));
        $chield=array();
        if(!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())){
            array_push($chield,$this->getleftpartner($mlm->getCodegauche()));
            array_push($chield,$this->getrightpartner($mlm->getCodedroite()));
        }
        elseif(!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())){
            array_push($chield,$this->getleftpartner($mlm->getCodegauche()));
        }
        elseif (empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())){
            array_push($chield,$this->getrightpartner($mlm->getCodedroite()));
        }
        for($i=0;$i<count($chield);$i++){
            if(!empty($chield[$i]->getCodegauche()) && !empty($chield[$i]->getCodedroite())){
                array_push($chield,$this->getleftpartner($chield[$i]->getCodegauche()));
                array_push($chield,$this->getrightpartner($chield[$i]->getCodedroite()));
            }
            elseif(!empty($chield[$i]->getCodegauche()) && empty($chield[$i]->getCodedroite())){
                array_push($chield,$this->getleftpartner($chield[$i]->getCodegauche()));
            }
            elseif (empty($chield[$i]->getCodegauche()) && !empty($chield[$i]->getCodedroite())){
                array_push($chield,$this->getrightpartner($chield[$i]->getCodedroite()));
            }
        }
        for($i=0;$i<count($chield);$i++){
            $lcp[] = [
                'nomcomplet' => $this->getmyinfo($chield[$i]->getIdpartenaire())->getNom().' '.
                    $this->getmyinfo($chield[$i]->getIdpartenaire())->getPrenom(),
                'mail' => $this->getmyinfo($chield[$i]->getIdpartenaire())->getEmail(),
                'id' => $this->getmyinfo($chield[$i]->getIdpartenaire())->getId(),
                'code' => $this->getmyinfo($chield[$i]->getIdpartenaire())->getCode(),
                'datevalidation' => $chield[$i]->getDateaffectation()->format('Y-m'),
            ];
        }
        if(count($chield)>0)
        return $lcp;
        else
            return null;
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
    function getmymlm($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($i);
        return $mlm;
    }
}
