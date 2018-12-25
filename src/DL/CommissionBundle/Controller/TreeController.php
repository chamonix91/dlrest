<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Mlm;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class TreeController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    function getinfobyid($i){
        $comarray = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($i);
        return $comarray;
    }
    function getcommandbyid($i){

        $neud = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:Commande')
            ->findOneByidpartenaire($i);
        //var_dump( $neud);
    if( $neud == null){
        return 0;
    }
        return $neud->getMontant();
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
    /**
     * @Rest\Get("/mytree/{id}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getArboAction(Request $request)
    {

        
        $time_start = microtime(true);

        $id = $request->get('id');
        // var_dump($id);die();

        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($id);
        $chield =array();
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();


      $formatted=$this->formneud($mlm);

        array_push($chield,$formatted);
        $base="['children'][0]";
        $base1="['children'][1]";
        $a=count($chield);
        for($c=0;$c<$a;$c++){
            if(!empty($chield[$c]['children'])) {
                if (count($chield[$c]['children']) == 2) {

                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][0]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][0]['name']));


                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][1]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][1]['name']));

                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $a = $a + 2;
                } elseif (count($chield[$c]['children']) == 1) {
                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][0]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][0]['name']));

                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $a++;
                }
            }
            /*if($c == 500){
                break;
            }*/

        }

        /****/
        $fchield=array();
        foreach ($chield as $p){
            if(!empty($p['children'])){
                array_push($fchield,$p);
            }

        }
        /*$fchield[0]['children'][0]=array_merge($fchield[0]['children'][0],$fchield[1]);
        return $fchield[0];*/
        //return array_merge($fchield[0]['children'][0],$fchield[1]);
       // var_dump($fchield);die();
        $k=count($fchield)-1;

        for($i=0,$count=count($fchield)-1;$i<$count;$i++){
            for($c=0,$count1=count($fchield);$c<$count1;$c++){
                if(count($fchield[$c]['children'])==2){
                if($fchield[$k]['name']==$fchield[$c]['children'][0]['name']){
                    //array_merge($fchield[$c]['children'][0],$fchield[$k]);
                    $fchield[$c]['children'][0]= array_merge($fchield[$k],$fchield[$c]['children'][0]);
                    break;
                }
                elseif($fchield[$k]['name']==$fchield[$c]['children'][1]['name']){
                    //array_merge($fchield[$c]['children'][1],$fchield[$k]);
                    $fchield[$c]['children'][1]=array_merge($fchield[$k],$fchield[$c]['children'][1]);
                    break;
                }
                }else{
                    if($fchield[$k]['name']==$fchield[$c]['children'][0]['name']){
                        //array_merge($fchield[$c]['children'][0],$fchield[$k]);
                        $fchield[$c]['children'][0]= array_merge($fchield[$k],$fchield[$c]['children'][0]);
                        break;
                    }
                }
            }
            $k--;
        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        if($k==-1){
            return $formatted;
        }
       // return (count($fchield));
        return ($fchield[0]);
        //return $formatted;


    }
    public function formneud($mlm){
       // if($mlm->getcodegauche()!='NULL' && $mlm->getcodedroite()!='NULL'
        if(!empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())
            && !empty($this->getleftpartner($mlm->getcodegauche()))&& !empty($this->getrightpartner($mlm->getCodedroite()))) {
              
                $formatted = [
                    'name' => $mlm->getIdpartenaire().' ('.$this->getcommandbyid($mlm->getIdpartenaire()).' )',
                    'title' => /*$this->getinfobyid($mlm->getIdpartenaire())->getNom() . ' '
                        . $this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),*/
                        $mlm->getDateaffectation(),
                    'className' => $this->colorbypack($mlm->getPaqueid()),
                    'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire().' ('.$this->getcommandbyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire()).' )',
                        'title' => /*$this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getNom() . ' ' .
                            $this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getPrenom(),*/
                            $this->getleftpartner($mlm->getcodegauche())->getDateaffectation(),
                        'className' => $this->colorbypack($this->getleftpartner($mlm->getcodegauche())->getPaqueid())],
                        ['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire().' ('.$this->getcommandbyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire()).' )',
                            'title' =>/* $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getNom() . ' ' .
                                $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom(),*/
                                $this->getrightpartner($mlm->getcodegauche())->getDateaffectation(),
                            'className' => $this->colorbypack($this->getrightpartner($mlm->getCodedroite())->getPaqueid())]
                    ],
                ];



        }

        //elseif($mlm->getcodegauche()!='NULL' && $mlm->getcodedroite()=='NULL'
        elseif(!empty($mlm->getcodegauche()) && empty($mlm->getcodedroite())
            && !empty($this->getleftpartner($mlm->getcodegauche()))) {

                $formatted = [
                    'name' => $mlm->getIdpartenaire().' ('.$this->getcommandbyid($mlm->getIdpartenaire()).' )',
                    /*'title' => $this->getinfobyid($mlm->getIdpartenaire())->getNom() . ' '
                        . $this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),*/
                    'title' => $mlm->getDateaffectation(),
                    'className' => $this->colorbypack($mlm->getPaqueid()),
                    'children' => [['name' => $this->getleftpartner($mlm->getcodegauche())->getIdpartenaire().' ('.$this->getcommandbyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire()).' )',
                        'title' => /*$this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getNom() . ' ' .
                            $this->getinfobyid($this->getleftpartner($mlm->getcodegauche())->getIdpartenaire())->getPrenom(),*/
                            $this->getleftpartner($mlm->getcodegauche())->getDateaffectation(),
                        'className' => $this->colorbypack($this->getleftpartner($mlm->getcodegauche())->getPaqueid())],

                    ],
                ];



        }
        //elseif($mlm->getcodegauche()=='NULL' && $mlm->getcodedroite()!='NULL'
        elseif(empty($mlm->getcodegauche()) && !empty($mlm->getcodedroite())
            && !empty($this->getrightpartner($mlm->getCodedroite()))) {

                $formatted = [
                    'name' => $mlm->getIdpartenaire().' ('.$this->getcommandbyid($mlm->getIdpartenaire()).' )',
                    'title' =>/* $this->getinfobyid($mlm->getIdpartenaire())->getNom() . ' '
                        . $this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),
                    'className' => $this->colorbypack($mlm->getPaqueid()),*/
                        $mlm->getDateaffectation(),
                    'children' => [
                        ['name' => $this->getrightpartner($mlm->getCodedroite())->getIdpartenaire(),
                            'title' => /*$this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getNom() . ' ' .
                                $this->getinfobyid($this->getrightpartner($mlm->getCodedroite())->getIdpartenaire())->getPrenom(),*/
                                $this->getrightpartner($mlm->getCodedroite())->getDateaffectation(),
                            'className' => $this->colorbypack($this->getrightpartner($mlm->getCodedroite())->getPaqueid())]
                    ],
                ];


        }
        else{

                $formatted = [

                    'name' => $mlm->getIdpartenaire().' ('.$this->getcommandbyid($mlm->getIdpartenaire()).' )',
                    'title' => /*$this->getinfobyid($mlm->getIdpartenaire())->getNom() . ' '
                        . $this->getinfobyid($mlm->getIdpartenaire())->getPrenom(),*/
                        $mlm->getDateaffectation(),
                    'className' => $this->colorbypack($mlm->getPaqueid()),

                ];




        }
        return $formatted;
    }
    //helllo
    /**
     * @Rest\Get("/mytreee/{id}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getArbo1Action($id)
    {

        $time_start = microtime(true);


        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);




        return $mlm->getId();
        //return $formatted;


    }
    /**
     * @Rest\Get("/walidos/{id}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getArbooAction($id)
    {


        $time_start = microtime(true);

        //$id = $request->get('id');
         //var_dump((int)$id);die();

        $mlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire(5300);
        //var_dump($mlm);die();
        $chield =array();
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();


        $formatted=$this->formneud($mlm);

        array_push($chield,$formatted);
        $base="['children'][0]";
        $base1="['children'][1]";
        $a=count($chield);
        for($c=0;$c<$a;$c++){
            if(!empty($chield[$c]['children'])) {
                if (count($chield[$c]['children']) == 2) {

                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][0]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][0]['name']));


                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][1]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][1]['name']));

                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $a = $a + 2;
                } elseif (count($chield[$c]['children']) == 1) {
                    $mlm = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('DLBackofficeBundle:Mlm')
                        //->findOneByidpartenaire($chield[$c]['children'][0]['name']);
                        ->findOneBy(array('idpartenaire' => $chield[$c]['children'][0]['name']));

                    $formatted = $this->formneud($mlm);
                    array_push($chield, $formatted);
                    $a++;
                }
            }
            /*if($c == 500){
                break;
            }*/

        }

        /****/
        $fchield=array();
        foreach ($chield as $p){
            if(!empty($p['children'])){
                array_push($fchield,$p);
            }

        }
        /*$fchield[0]['children'][0]=array_merge($fchield[0]['children'][0],$fchield[1]);
        return $fchield[0];*/
        //return array_merge($fchield[0]['children'][0],$fchield[1]);
        // var_dump($fchield);die();
        $k=count($fchield)-1;

        for($i=0,$count=count($fchield)-1;$i<$count;$i++){
            for($c=0,$count1=count($fchield);$c<$count1;$c++){
                if(count($fchield[$c]['children'])==2){
                    if($fchield[$k]['name']==$fchield[$c]['children'][0]['name']){
                        //array_merge($fchield[$c]['children'][0],$fchield[$k]);
                        $fchield[$c]['children'][0]= array_merge($fchield[$k],$fchield[$c]['children'][0]);
                        break;
                    }
                    elseif($fchield[$k]['name']==$fchield[$c]['children'][1]['name']){
                        //array_merge($fchield[$c]['children'][1],$fchield[$k]);
                        $fchield[$c]['children'][1]=array_merge($fchield[$k],$fchield[$c]['children'][1]);
                        break;
                    }
                }else{
                    if($fchield[$k]['name']==$fchield[$c]['children'][0]['name']){
                        //array_merge($fchield[$c]['children'][0],$fchield[$k]);
                        $fchield[$c]['children'][0]= array_merge($fchield[$k],$fchield[$c]['children'][0]);
                        break;
                    }
                }
            }
            $k--;
        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        if($k==-1){
            return $formatted;
        }
        //var_dump('hy');die();
        // return (count($fchield));
        return ($fchield[0]);
        //return $formatted;


    }
}
