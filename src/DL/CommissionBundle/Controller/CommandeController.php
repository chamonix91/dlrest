<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/commande")
     */
    public function getAllCommandeAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Commande')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findBy(array('affectation'=>0));
        $commandeinfo = array();
        for($c=0;$c<count($mlms);$c++){
            $partner = $this->getDoctrine()->getRepository('DLAchatBundle:Commande')
                ->findOneBy($mlms[$c]->getIdpartenaire());
        }

        return $restresult;

    }
    /**
     * @Rest\Get("/commande/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getCommandeByIdAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Commande')
            ->find($request->get('id'));

        return($user);
    }
}
