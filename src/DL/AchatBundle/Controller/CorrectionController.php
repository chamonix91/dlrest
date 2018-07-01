<?php

namespace DL\AchatBundle\Controller;

use DL\AchatBundle \Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Mlm;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class CorrectionController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/correction")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function getArboAction(Request $request)
    {
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findAll();

        $x=count($mlms);
        $er=array();
        $er1=array();

        $em = $this->getDoctrine()->getManager();
        for($i=0;$i<$x;$i++){
            if(($mlms[$i]->getCodegauche())!= null && ($mlms[$i]->getCodedroite())!= null) {
                $mlm = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('DLUserBundle:User')
                    ->findOneBycode($mlms[$i]->getCodegauche());
            }
            if(empty($mlm)){
                array_push($er,$mlms[$i]->getId());
            }
        }

      /*  $x=count($er);
        for($i=0;$i<$x;$i++){

            $tmp = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLAchatBundle:CoreUserUser')

                ->findOneByemail($er[$i]->getEmail());
            if(!empty($tmp)){
            $pr = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLAchatBundle:DreamlifePartnerPartner')
                ->findBytreeParentId($tmp->getUid()-1);
            if(count($pr)==1){
                $mlms = new Mlm();
                $mlms->setIdpartenaire($er[$i]->getId());
                $mlms->setCodegauche($pr[0]->getCode());
                $mlms->setNbrepartenairegauche(0);
                $mlms->setNbrepartenairedroite(0);
                $em->persist($mlms);
                $em->flush();
                array_push($er1,$er[$i]->getId());
            }
                if(count($pr)==2){
                    $mlms = new Mlm();
                    $mlms->setIdpartenaire($er[$i]->getId());
                    $mlms->setCodegauche($pr[0]->getCode());
                    $mlms->setCodedroite($pr[1]->getCode());
                    $mlms->setNbrepartenairegauche(0);
                    $mlms->setNbrepartenairedroite(0);
                    $em->persist($mlms);
                    $em->flush();
                    array_push($er1,$er[$i]->getId());
                }
            }
        }
        return 'heloo';*/
        return $er;
    }
    /**
     * @Rest\Get("/corre")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
   public function getcomAction(Request $request){
       var_dump('psss');die();
       $com = $this->get('doctrine.orm.entity_manager')
           ->getRepository('DLAchatBundle:DreamlifePartnerSale')
           ->findAll();
       $x=count($com);
       $erro= array();
       $em = $this->getDoctrine()->getManager();
       for($i=0;$i<$x;$i++){
          $part = $this->get('doctrine.orm.entity_manager')
               ->getRepository('DLUserBundle:User')
               ->findOneBycode($com[$i]->getPartnerCode());
          if(!empty($part)){
              $commande = new Commande();
              $commande->setEtat(0);
              $commande->setIdpartenaire($part->getId());
              $commande->setMontant($com[$i]->getAmount());
              $em->persist($commande);
              $em->flush();
          }
          else{
              array_push($erro,$com[$i]->getUid());
          }
       }
return $erro;
   }
}
