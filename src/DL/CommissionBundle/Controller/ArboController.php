<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Mlm;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ArboController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/tree/{id}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getTreeAction(Request $request){
        $id = $request->get('id');
       // var_dump($id);die();
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($id);
        if(!empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())){
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=> $mlm->getAffectation(),
                'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire(),
                    'title' => $this->getleftpartner($mlm->getcodegauche())->getAffectation()],
                    ['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                        'title' => $this->getrightpartner($mlm->getCodedroite())->getAffectation() ]
                ],
                /***/
            ];
        }elseif (empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())){
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=> $mlm->getAffectation(),
                'children' => [['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                    'title' => $this->getrightpartner($mlm->getCodedroite())->getAffectation()],
                ],
            ];
        }elseif ((!empty($mlm->getcodegauche()) && empty($mlm->getcodedroite()))){
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=> $mlm->getAffectation(),
                'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire(),
                    'title' => $this->getleftpartner($mlm->getcodegauche())->getAffectation()],
                ],
            ];
        }else{
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=> $mlm->getAffectation(),
            ];
        }

        //var_dump($formatted['children'][0]['name']);die();
        //var_dump(count($formatted['children']));die();
        
        return $formatted;


       // for ($c = 0; $c < count($mlms); $c++) {}

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
}
