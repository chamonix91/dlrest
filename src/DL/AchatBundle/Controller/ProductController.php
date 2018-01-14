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
    public function imgAction(Request $request)
    {
        $data = new Produit();
        $prix= $request->get('prix');
        $libelle= $request->get('libelle');
        $data->setPrix($prix);
        $data->setLibelle($libelle);
        //var_dump($data);die();
        $data->setImage1($request->get('image1'));
        $data->setImage2($request->get('image2'));
        $data->setImage3($request->get('image3'));
        $data->setQuantite($request->get('quantite'));
        $data->setDescription($request->get('description'));
        $data->setCategorie('a');
        $data->setSouscategorie('78');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("User Added Successfully", Response::HTTP_OK);
        return $view;
    }
    /**
     * @Rest\Delete("/product/{id}")
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Produit')
            ->find($request->get('id'));

        $em->remove($user);
        $em->flush();
    }

    /**
     * @Rest\Put("/product/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function putAction(Request $request){
        $data = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:Produit')
            ->find($request->get('id'));

        if (empty($data)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        $prix= $request->get('prix');
        $libelle= $request->get('libelle');
        $data->setPrix($prix);
        $data->setLibelle($libelle);
        $data->setQuantite($request->get('quantite'));
        $data->setDescription($request->get('description'));


        $em = $this->get('doctrine.orm.entity_manager');

        $em->merge($data);
        $em->flush();
        return $data;

    }
    /**
     * @Rest\Get("/product")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Produit')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }
    /**
     * @Rest\Get("/product/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getbyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Produit')
            ->find($request->get('id'));

        return($user);
    }
    /**
     * @Rest\Get("/pic/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getbypicAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Produit')
            ->find($request->get('id'));
        $photo1= (stream_get_contents($user->getImage1()));
        $photo2= (stream_get_contents($user->getImage2()));
        $photo3= (stream_get_contents($user->getImage3()));
        //var_dump($photo);die();
        return(array('pic1'=>$photo1,'pic2'=>$photo2,'pic3'=>$photo3));
    }

}
