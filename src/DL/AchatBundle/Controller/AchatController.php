<?php

namespace DL\AchatBundle\Controller;

use DL\AchatBundle \Entity\Achat;
use DL\AchatBundle \Entity\Produit;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DL\AchatBundle\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile as uf;
//Symfony\\Component\\HttpFoundation\\File\\UploadedFile


class AchatController extends FOSRestController
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
    /**
     * @Rest\Get("/achat")
     */

    public function getAchatAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Achat')
            ->findAll();
        foreach ($user as $result) {
            $partner = $em->getRepository('DLUserBundle:User')
                ->find($result->getIdpartenaire());
            $formatted[] = [
                'datec' => $result->getDatecreation(),
                'prix' => $result->getMontant(),
                'cin' => $partner->getCin(),
                'nom' => $partner->getNom(),
                'prenom' => $partner->getPrenom(),
                'code' => $partner->getCode(),

            ];
        }
        return $formatted;
    }


}
