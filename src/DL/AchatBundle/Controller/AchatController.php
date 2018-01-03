<?php

namespace DL\AchatBundle\Controller;

use DL\AchatBundle \Entity\Achat;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


class AchatController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }



    /**
     * @Rest\Post("/addAchat")
     * @param Request $request
     * @return View
     */

    public function newAchatAction(Request $request)
    {
        /*var_dump($request);
        die();*/
        $data = new Achat;

        $idpartenaire = $request->get('idpartenaire');
        $montant = $request->get('montant');
        //$dateconfirmation= $request->get('dateconfirmation');
        //$datecreation= $request->get('datecreation');

        if(empty($idpartenaire) || empty($montant))
        {
            return new View("aucun achat effectué", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setIdpartenaire($idpartenaire);
        //$data->setDatecreation(new DateTime());
        //$data->setDateconfirmation($dateconfirmation);
        $data->setMontant($montant);

        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("Achat effectué avec succès", Response::HTTP_OK);

        return $view;
    }

}
