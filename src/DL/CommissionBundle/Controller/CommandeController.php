<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

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
                ->findOneByidpartenaire($mlms[$c]->getIdpartenaire());
            $produit = $this->getDoctrine()->getRepository('DLAchatBundle:Produit')
                ->find($partner->getIdproduit());
            $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLUserBundle:User')
                ->find($partner->getIdpartenaire());
            $intro = [
                'id'=>$mlms[$c]->getIdpartenaire(),
                'cin'=>$user->getCin(),
                'email'=>$user->getEmail(),
                'nom'=>$produit->getLibelle(),
                'prix'=>$produit->getPrix(),
                'datec'=>$partner->getDate()
            ];
            array_push($commandeinfo, $intro);


        }

        return $commandeinfo;

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
    /**
     * @Rest\Put("/actcommande/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function ativeAction(Request $request){
        //var_dump(new \DateTime('now'));die();
        $data = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($request->get('id'));



        $data->setAffectation(1);
        $data->setDateaffectation(new \DateTime('now'));


        $em = $this->get('doctrine.orm.entity_manager');

        $em->merge($data);
        $em->flush();
        return $data;

    }
}
