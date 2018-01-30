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
        $x=0;
        if(!empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())){
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
        }elseif (empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())){
            //var_dump('heloo');die();
           // var_dump($this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom());die();
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
            //var_dump($formatted);die();
        }
        elseif ((!empty($mlm->getcodegauche()) && empty($mlm->getcodedroite()))){
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
            $x=1;
            $formatted = [
                'name'=>$mlm->getIdpartenaire(),
                'title'=>$this->getinfobyid($mlm->getIdpartenaire())->getNom() .' '.$this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                'className'=> $this->colorbypack($mlm->getPaqueid()),
            ];
        }

        if($x==0){
        for($i=0;$i<count($formatted['children']);$i++){

            if(!empty($this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche()) &&
                !empty($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())) {
                //var_dump($this->getmlmbyid($formatted['children'][$i]['name']));die();
                //var_dump('zouz');die();
                $intro = [
                    'name' => $this->getmlmbyid($formatted['children'][$i]['name'])->getIdpartenaire(),
                    'title'=>$this->getinfobyid($formatted['children'][$i]['name'])->getNom() .' '
                        .$this->getinfobyid($formatted['children'][$i]['name'])->getPrenom(),
                    'className' => $this->colorbypack($this->getmlmbyid($formatted['children'][$i]['name'])->getPaqueid()),
                    'children' => [['name' => $this->getleftpartner($this->getmlmbyid($formatted['children'][$i]['name'])
                        ->getcodegauche())->getIdpartenaire(),
                        'title'=>$this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'className' => $this->colorbypack($this->getleftpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getPaqueid())],
                        ['name' => $this->getrightpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire(),
                            'title'=>$this->getinfobyid($this->getrightpartner(
                                    $this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire())->getNom() .' '.
                                $this->getinfobyid($this->getrightpartner(
                                    $this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire())->getPrenom(),
                            'className' => $this->colorbypack($this->getrightpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getPaqueid())]
                    ],
                    /***/
                ];
            }
                elseif(empty($this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche()) &&
                    !empty($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())){
               // var_dump('m e droit');die();
                    $intro = [
                        'name'=>$this->getmlmbyid($formatted['children'][$i]['name'])->getIdpartenaire(),
                        'title'=>$this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'className'=> $this->colorbypack($this->getmlmbyid($formatted['children'][$i]['name'])->getPaqueid()),
                        'children' => [
                            ['name' => $this->getrightpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire(),
                                'title'=>$this->getinfobyid($this->getrightpartner(
                                        $this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire())->getNom() .' '.
                                    $this->getinfobyid($this->getrightpartner(
                                        $this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getIdpartenaire())->getPrenom(),
                                'className' => $this->colorbypack($this->getrightpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())->getPaqueid()) ]
                        ],
                        /***/
                    ];

            }elseif(!empty($this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche()) &&
                    empty($this->getmlmbyid($formatted['children'][$i]['name'])->getCodedroite())){
               // var_dump('m e gauch');die();
                    $intro = [
                        'name'=>$this->getmlmbyid($formatted['children'][$i]['name'])->getIdpartenaire(),
                        'title'=>$this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'className'=> $this->colorbypack($this->getmlmbyid($formatted['children'][$i]['name'])->getPaqueid()),
                        'children' => [['name' => $this->getleftpartner($this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire(),
                            'title'=>$this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getNom() .' '.
                            $this->getinfobyid($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'className' => $this->colorbypack($this->getleftpartner(
                                $this->getmlmbyid($formatted['children'][$i]['name'])->getcodegauche())->getPaqueid())],

                        ],
                        /***/
                    ];

            }else{
                $intro = [
                    'name'=>$this->getmlmbyid($formatted['children'][$i]['name'])->getIdpartenaire(),
                    'title'=>$this->getinfobyid($formatted['children'][$i]['name'])->getNom() .' '.
                        $this->getinfobyid($formatted['children'][$i]['name'])->getPrenom(),
                    'className'=> $this->colorbypack($this->getmlmbyid($formatted['children'][$i]['name'])->getPaqueid()),
                ];
            }
            $formatted['children'][$i]=$intro;
        }}
        //var_dump($formatted['children'][0]['children']);die();
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
