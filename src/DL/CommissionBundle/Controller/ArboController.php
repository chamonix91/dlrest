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

    public function getArboAction(Request $request)
    {
        $id = $request->get('id');
        // var_dump($id);die();

        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($id);
        if($mlm->getcodegauche()!= 'NULL' && $mlm->getcodedroite()!= 'NULL'
            && !empty($this->getleftpartner($mlm->getcodegauche())&& !empty($this->getrightpartner($mlm->getCodedroite())))){

            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '
                    .$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
                'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire(),
                    'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '.
                        $this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getPrenom(),
                    'className' => $this->colorbypack($this->getleftpartner($mlm->getcodegauche())->getPaqueid())],
                    ['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                        'title'=>$this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom(),
                        'className' => $this->colorbypack($this->getrightpartner($mlm->getCodedroite())->getPaqueid()) ]
                ],
                /***/
            ];
        }

    }

    /**
     * @Rest\Get("/tree/{id}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getTreeAction(Request $request){
        //var_dump('heello');die();
        $id = $request->get('id');
       // var_dump($id);die();

        /*$mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($id);*/
        return $this->formneud($id);



       // for ($c = 0; $c < count($mlms); $c++) {}

    }
    public function formneud($i){
        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($i);

//var_dump(!empty($this->getrightpartner($mlm->getCodedroite())));die();
        //if(!empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())
        if($mlm->getcodegauche()!='NULL' && $mlm->getcodedroite()!='NULL'
            && !empty($this->getleftpartner($mlm->getcodegauche()))&& !empty($this->getrightpartner($mlm->getCodedroite()))){

            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '
                    .$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
                'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire(),
                    'title'=>$this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getNom() .' '.
                        $this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getPrenom(),
                    'className' => $this->colorbypack($this->getleftpartner($mlm->getcodegauche())->getPaqueid())],
                    ['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                        'title'=>$this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom(),
                        'className' => $this->colorbypack($this->getrightpartner($mlm->getCodedroite())->getPaqueid()) ]
                ],
                /***/
            ];
            //}elseif (empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())){
        }elseif(empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())
            &&  !empty($this->getrightpartner($mlm->getCodedroite()))){
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '.$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
                'children' => [['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                    'title'=>$this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getNom() .' '.
                        $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom(),
                    'className' => $this->colorbypack($this->getrightpartner($mlm->getCodedroite())->getPaqueid())]
                ],
            ];

        }
        //elseif ((!empty($mlm->getcodegauche()) && empty($mlm->getcodedroite()))){
        elseif(!empty($mlm->getcodegauche()) && empty($mlm->getcodedroite())
            && !empty($this->getleftpartner($mlm->getcodegauche()))){
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '.$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
                'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire(),
                    'title'=>$this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getNom() .
                        ' '.$this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getPrenom(),
                    'className' => $this->colorbypack($this->getleftpartner($mlm->getcodegauche())->getPaqueid())],
                ],
            ];
        }else{
            //var_dump('dea');die();

            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '.$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
            ];
        }



        return $formatted;
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
    function colorbypack($i){
        if($i==1){
            return 'middle-level';
        }
        elseif ($i==2){
            return 'product-dept';
        }
        elseif ($i==3){
            return 'rd-dept';
        }
        elseif ($i==4){
            return 'pipeline1';
        }
        else{
           return 'frontend1';
        }
        /*else ($i==5){
            return 'frontend1';
        }*/

    }
}
