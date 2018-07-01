<?php

namespace DL\BackofficeBundle\Controller;

use DL\BackofficeBundle \Entity\Mlm as Mlm;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;

class FautInscritController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/fautinscrit")
     */
    public function getfautinscritAction()
    {

        $users = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();
        $mlms = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')->findAll();
        /*
         * $lchield=array();
            $rchield=array();
         */
        for ($c = 0; $c < count($mlms); $c++) {
            if (empty($mlms[$c]->getCodegauche()) && empty($mlms[$c]->getCodedroite())) {
                $lchield=array();
                $rchield=array();
            } elseif (!empty($mlms[$c]->getCodegauche()) && empty($mlms[$c]->getCodedroite())){
                $lchield = array();
                $rchield=array();
            array_push($lchield, $mlms[$c]->getCodegauche());
            for ($i = 0; $i < count($lchield); $i++) {
                $user = $this->getDoctrine()->getRepository('DLUserBundle:User')
                    ->findOneBy(array('code' => $lchield[$i]));
                $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                    ->findOneBy(array('idpartenaire' => $user->getId()));
                if (!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                    array_push($lchield, $mlm->getCodegauche());
                    array_push($lchield, $mlm->getCodedroite());
                } elseif (!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())) {
                    array_push($lchield, $mlm->getCodegauche());
                } elseif (empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                    array_push($lchield, $mlm->getCodedroite());
                } else {
                    var_dump('aaaa');
                }
            }

        }elseif (empty($mlms[$c]->getCodegauche()) && !empty($mlms[$c]->getCodedroite())){
                $lchield = array();
                $rchield=array();
                array_push($rchield, $mlms[$c]->getCodedroite());
                for ($i = 0; $i < count($rchield); $i++) {
                    $user = $this->getDoctrine()->getRepository('DLUserBundle:User')
                        ->findOneBy(array('code' => $lchield[$i]));
                    $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                        ->findOneBy(array('idpartenaire' => $user->getId()));
                    if (!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodegauche());
                        array_push($rchield, $mlm->getCodedroite());
                    } elseif (!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodegauche());
                    } elseif (empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodedroite());
                    } else {
                        var_dump('aaaa');
                    }
                }

            }
            else{
                $lchield = array();
                $rchield = array();
                array_push($lchield, $mlms[$c]->getCodegauche());
                array_push($rchield, $mlms[$c]->getCodedroite());
                for ($i = 0; $i < count($lchield); $i++) {
                    $user = $this->getDoctrine()->getRepository('DLUserBundle:User')
                        ->findOneBy(array('code' => $lchield[$i]));
                    $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                        ->findOneBy(array('idpartenaire' => $user->getId()));
                    if (!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($lchield, $mlm->getCodegauche());
                        array_push($lchield, $mlm->getCodedroite());
                    } elseif (!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())) {
                        array_push($lchield, $mlm->getCodegauche());
                    } elseif (empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($lchield, $mlm->getCodedroite());
                    } else {
                        var_dump('aaaa');
                    }
                }
                for ($i = 0; $i < count($rchield); $i++) {
                    $user = $this->getDoctrine()->getRepository('DLUserBundle:User')
                        ->findOneBy(array('code' => $rchield[$i]));
                    $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
                        ->findOneBy(array('idpartenaire' => $user->getId()));
                    if (!empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodegauche());
                        array_push($rchield, $mlm->getCodedroite());
                    } elseif (!empty($mlm->getCodegauche()) && empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodegauche());
                    } elseif (empty($mlm->getCodegauche()) && !empty($mlm->getCodedroite())) {
                        array_push($rchield, $mlm->getCodedroite());
                    } else {
                        var_dump('aaaa');
                    }
                }
            }
            $mlms[$c]->setNbrepartenairegauche(count($lchield));
            $mlms[$c]->setNbrepartenairedroite(count($rchield));
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($mlms[$c]);
            $em->flush();
    }

        var_dump(count('end'));die();


    }
    /**
     * @Rest\Get("/fautinscritt",name="aaaaa")
     */
    public function getfautitnscritAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        var_dump('wfé');die();
        $x=count($restresult);
        $terr = array();

        return $terr;
    }
    /**
     * @Rest\Get("/fautinscritts",name="abbbaa")
     */
    public function getfautitnscrittAction()
    {


       // $qb = $this->getEntityManager()->createQueryBuilder();

        $qb = $this->getDoctrine()->getManager();
        $qb = $qb->createQueryBuilder();
        $qb->select('revenu.email');
        $qb->from('DLUserBundle:User','revenu');
        $count = $qb->getQuery()->getArrayResult();
        $qb = $this->getDoctrine()->getManager();
        $qb = $qb->createQueryBuilder();
        $qb->select('count(revenu.email)');
        $qb->from('DLUserBundle:User','revenu');
        $x = $qb->getQuery()->getArrayResult();
        $eret= array();
        //var_dump($x[0][1]);die();
        //var_dump((int)$x[0]);die();
        for($c=0;$c<200;$c++) {

            $qb = $this->getDoctrine()->getManager();
            $qb = $qb->createQueryBuilder();
            $qb->select('users.email');
            $qb->from('DLUserBundle:User', 'users');
            $qb->where('users.emailenrolleur = :name OR users.emaildirect = :name');
            $qb->setParameter('name', $count[$c]['email']);
            if (empty($qb->getQuery()->getArrayResult())) {
                array_push($eret, $count[$c]['email']);

            }
        }
        return ($eret);
    }
    /**
     * @Rest\Get("/boud",name="boudren")
     */
    public function getboudrenscritAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')->find(3239);
        $mlm = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>3239));
        $rchield=array();
        $lchield=array();
        $l = $this->getDoctrine()->getRepository('DLUserBundle:User')
            ->findOneBy(array('code'=>'C002074'));
        $r = $this->getDoctrine()->getRepository('DLUserBundle:User')
            ->findOneBy(array('code'=>'C002078'));
        $l1 = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>$l->getId()));
        $r1 = $this->getDoctrine()->getRepository('DLBackofficeBundle:Mlm')
            ->findOneBy(array('idpartenaire'=>$r->getId()));

        array_push($lchield,$l1);
        array_push($rchield,$r1);
        for ($i = 0; $i < count($lchield); $i++) {
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
        for($i =0; $i< count($rchield);$i++){
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
        }
        var_dump(count($rchield));
        var_dump(count($lchield));
        usort($lchield, array($this, "cmp"));
        usort($rchield, array($this, "cmp"));

        var_dump('*****');
        $a=0;
        for($i =0; $i< count($rchield);$i++){
            if($rchield[$i]->getDateaffectation()<=new \DateTime('2018-06-07 07:39:07') &&
                $rchield[$i]->getDateaffectation()>=new \DateTime('2018-06-07 06:07:25')){
               /* var_dump($rchield[$i]->getIdpartenaire());
                var_dump($rchield[$i]->getDateaffectation());*/
               $a++;
            }
        }
        $b=0;
        for($i =0; $i< count($lchield);$i++){
            if($lchield[$i]->getDateaffectation()<=new \DateTime('2018-06-07 07:39:07') &&
                $lchield[$i]->getDateaffectation()>=new \DateTime('2018-06-07 06:07:25')){
                /* var_dump($rchield[$i]->getIdpartenaire());
                 var_dump($rchield[$i]->getDateaffectation());*/
                $b++;
            }
        }
        var_dump('*****');
        var_dump($a);
        var_dump($b);
        /*for($i =0; $i< count($lchield);$i++){
            if($lchield[$i]->getIdpartenaire()==9159 || $lchield[$i]->getIdpartenaire()==9186 || $lchield[$i]->getIdpartenaire()==9244){
                var_dump($lchield[$i]->getIdpartenaire());
                var_dump($lchield[$i-1]->getIdpartenaire());
                var_dump($rchield[$i]->getIdpartenaire());
                var_dump($rchield[$i-1]->getIdpartenaire());
                var_dump('hhhhhhhhhhhh');
            }
        }*/
        die();
        return $mlm;

    }
    public function getleftpartner($code)
    {
        $user = $this->getDoctrine()
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->getDoctrine()
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
        $user = $this->getDoctrine()
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->getDoctrine()
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
    /**
     * @Rest\Get("/walid",name="wak")
     */
    public function hello(){
        var_dump('hie');die();
    }

}
