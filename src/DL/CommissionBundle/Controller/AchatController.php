<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AchatController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/affachat")
     */
    public function getAllAchatAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Achat')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findBy(array('affectation'=>0));
        $commandeinfo = array();
        for($c=0;$c<count($restresult);$c++){
            $produit = $this->getDoctrine()->getRepository('DLAchatBundle:Produit')
                ->find($restresult[$c]->getIdproduit());
            $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLUserBundle:User')
                ->find($restresult[$c]->getIdpartenaire());
            $intro = [
                'id'=>$restresult[$c]->getIdpartenaire(),
                'cin'=>$user->getCin(),
                'email'=>$user->getEmail(),
                'nom'=>$produit->getLibelle(),
                'prix'=>$produit->getPrix(),
                'datec'=>$restresult[0]->getDatecreation()
            ];
            array_push($commandeinfo, $intro);


        }

        return $commandeinfo;

    }
}
