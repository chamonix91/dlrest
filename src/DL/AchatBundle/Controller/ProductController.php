<?php

namespace DL\AchatBundle\Controller;

use DL\AchatBundle \Entity\Produit;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/product/", name="_product")
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $data = new Produit();
        $prix= $request->get('prix');
        $libelle= $request->get('libelle');
        $data->setPrix($prix);
        $data->setLibelle($libelle);
        $data->setImage1('aaa');
        $data->setImage2('bbbb');
        $data->setImage3('cccc');
        $data->setQuantite(5);
        $data->setCategorie('a');
        $data->setSouscategorie('78');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("User Added Successfully", Response::HTTP_OK);

        return $view;
    }
    
}
