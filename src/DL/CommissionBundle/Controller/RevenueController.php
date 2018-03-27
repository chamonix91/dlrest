<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;


class RevenueController extends FOSRestController
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

    public function getleftpartner($tab1,$tab,$i){

        for($c=0;$c<count($tab1);$c++){

            if($i==$tab1[$c]->getCode()){
                $id=$tab1[$c];break;
            }
        }
        if(empty($id)){
            return null;
        }

        for($c=0;$c<count($tab);$c++){

            if($id->getId()==$tab[$c]->getIdpartenaire()){
                return $tab[$c];
            }
        }
        return null;
    }
    public function getrightpartner($tab1,$tab,$i){
        //var_dump('kkkkkk');die();
        for($c=0;$c<count($tab1);$c++){
            if($i==$tab1[$c]->getCode()){
                $id=$tab1[$c];break;
            }
        }
        if(empty($id)){
            return null;
        }
        for($c=0;$c<count($tab);$c++){

            if($id->getId()==$tab[$c]->getIdpartenaire()){
                return $tab[$c];
            }
        }
        return null;
    }
    /**
     * @Rest\Get("/revenue/{id}/{year}")
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
        $date = new \DateTime($year . '-' . $month . '-' . $day . ' 23:59:59');
        $dated = new \DateTime($year . '-' . $month . '-' . '01 01:00:00');
        /***prerequit***/
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findAll();
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findBy(array('affectation'=>1));
        $activer = array();
        $new = array();
        for ($c = 0; $c < count($mlms); $c++) {
            if ($mlms[$c]->getcodegauche() != 'NULL' && $mlms[$c]->getcodedroite() != 'NULL'){
                array_push($activer,$mlms[$c]);
            }
            if ($mlms[$c]->getDateaffectation()>=$dated && $mlms[$c]->getDateaffectation()<=$date){
                array_push($new,$mlms[$c]);
            }
        }
        //var_dump($activer);die();

       // var_dump('terminé');die();
        $mydirect = array();
        $lchield = array();
        $rchield = array();
        //var_dump(count($activer));die();
        $commissione = array();
        for($c=0;$c<500;$c++){
           // var_dump('aaaa');die();
            $test = false;
            if (!empty($this->getleftpartner($users,$mlms,$activer[$c]->getcodegauche())) &&
                $this->getrightpartner($users,$mlms,$activer[$c]->getcodedroite())) {
                if ($activer[$c]->getcodegauche() != 'NULL' && $activer[$c]->getcodedroite() != 'NULL'
                    && $this->getleftpartner($users,$mlms,$activer[$c]->getcodegauche())->getAffectation() == 1 &&
                    $this->getrightpartner($users,$mlms,$activer[$c]->getcodedroite())->getaffectation() == 1) {
                    $test = true;

                    array_push($lchield, $this->getleftpartner($users,$mlms,$activer[$c]->getcodegauche()));
                    array_push($rchield, $this->getrightpartner($users,$mlms,$activer[$c]->getcodedroite()));
                }
            }
         //   var_dump(count($lchield));die();


        if($test ) {

            for ($i = 0; $i <count($rchield) ; $i++) {


                if (!empty($rchield[$i])) {

                    if(!empty($this->getmyinfo($activer[$c]->getIdpartenaire()))) {
                        if ($rchield[$i]->getCodedirect() ==
                            $this->getmyinfo($activer[$c]->getIdpartenaire())->getCode()) {
                            array_push($mydirect, $rchield[$i]);
                        }
                    }
                    if ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {

                        if (!empty($this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche())) &&
                            !empty($this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()))) {
                            //var_dump('iiiii');die();
                            $t = 0;
                            for ($ing = 0; $ing < count($rchield); $ing++) {
                                if ($this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche()) == $rchield[$i] ||
                                    $this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()) == $rchield[$i]) {
                                  //  var_dump('marita');die();
                                    $t = 1;

                                }
                            }
                            if ($t == 1) {
                                break;
                            }

                            array_push($rchield, $this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche()));
                            array_push($rchield, $this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()));
                        }

                    } elseif ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() == 'NULL')) {

                        if (!empty($this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche()))) {
                            /*var_dump($activer[$c]->getId());
                            var_dump($this->getleftpartner($activer,$rchield[$i]->getcodegauche())->getId());die();*/
                            $t = 0;
                            for ($ing = 0; $ing < count($rchield); $ing++) {
                                if ($this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche()) == $rchield[$ing]) {
                                    $t = 1;
                                }
                            }
                            if ($t == 1) {
                                var_dump('break');die();
                                break;
                            }

                            array_push($rchield, $this->getleftpartner($users,$mlms,$rchield[$i]->getcodegauche()));
                        }
                    } elseif ($rchield[$i]->getcodegauche() == 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {

                        if (!empty($this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()))) {
                            $t = 0;
                            for ($ing = 0; $ing < count($rchield); $ing++) {
                                if (
                                    $this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()) == $rchield[$ing]) {
                                    $t = 1;
                                }
                            }
                            if ($t == 1) {
                                break;
                            }

                            array_push($rchield, $this->getrightpartner($users,$mlms,$rchield[$i]->getcodedroite()));
                        }
                    }
                }
            }//fin boucle rchield*/
            for ($i = 0; $i < count($lchield); $i++) {

                if(!empty($lchield[$i])) {
                    if(!empty($this->getmyinfo($activer[$c]->getIdpartenaire()))) {
                        if ($lchield[$i]->getCodedirect() == $this->getmyinfo($mlms[$c]->getIdpartenaire())->getCode()) {
                            array_push($mydirect, $lchield[$i]);
                        }
                    }

                    if ($lchield[$i]->getcodegauche() != 'NULL' && $lchield[$i]->getcodedroite() != 'NULL'
                    ) {
                        if (!empty($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche())) &&
                            !empty($this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite()))) {
                            if($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche())->getIdpartenaire()==$mlms[$c]->getIdpartenaire() ||
                                $this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite())->getIdpartenaire()==$mlms[$c]->getIdpartenaire()){
                                //var_dump($lchield[$i]);die();
                                break;
                            }
                            $t=0;
                            for($ing=0;$ing<count($lchield);$ing++){
                                if($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche())==$lchield[$ing] ||
                                    $this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite())==$lchield[$ing] ){
                                    $t=1;
                                }
                            }
                            if($t==1){
                                break;
                            }

                            array_push($lchield, $this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche()));
                            array_push($lchield, $this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite()));
                            /* if($this->getleftpartner($lchield[$i]->getcodegauche())->getDateaffectation() > $startMonth){
                                 arr
                             }*/
                        }
                    } elseif ($lchield[$i]->getcodegauche() != 'NULL' && $lchield[$i]->getcodedroite() == 'NULL') {
                        if (!empty($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche()))) {
                            if($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche())->getIdpartenaire()==$mlms[$c]->getIdpartenaire() ){
                                //var_dump($lchield[$i]);die();
                                break;
                            }
                            $t=0;
                            for($ing=0;$ing<count($lchield);$ing++){
                                if($this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche())==$lchield[$ing]  ){
                                    $t=1;
                                }
                            }
                            if($t==1){
                                break;
                            }

                            array_push($lchield, $this->getleftpartner($users,$mlms,$lchield[$i]->getcodegauche()));
                            //array_push($nar, 1);
                        }
                    } elseif ($lchield[$i]->getcodegauche() == 'NULL' && $lchield[$i]->getcodedroite() != 'NULL') {
                        if (
                        !empty($this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite()))) {
                            if($this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite())->getIdpartenaire()==$mlms[$c]->getIdpartenaire() ){
                                //var_dump($lchield[$i]);die();
                                break;
                            }
                            $t=0;
                            for($ing=0;$ing<count($lchield);$ing++){
                                if(
                                    $this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite())==$lchield[$ing] ){
                                    $t=1;
                                }
                            }
                            if($t==1){
                                break;
                            }

                            array_push($lchield, $this->getrightpartner($users,$mlms,$lchield[$i]->getcodedroite()));
                            //array_push($nar, 1);
                        }
                    }
                }
            }//fin boucle lchield

            //var_dump('aaaa');
        }//fin if test
            /*var_dump(count($lchield));
            var_dump(count($rchield));*/

                var_dump(count($lchield));
                var_dump(count($rchield));

            $mydirect = array();
            $lchield = array();
            $rchield = array();
        }
        var_dump('fin');die();
    }

    public function test(){

    }
}
