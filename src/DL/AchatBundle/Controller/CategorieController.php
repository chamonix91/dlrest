<?php

namespace DL\AchatBundle\Controller;

use DL\AchatBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategorieController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/categorieaff")
     */
    public function getcategorieAction()
    {
        //
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Categorie')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;
    }
    /**
     * @Rest\Post("/addcategorie/", name="_challenge")
     * @param Request $request
     * @return View
     */
    public function addcateAction(Request $request)
    {
        $data = new Categorie();
        $libelle= $request->get('libelle');
        $data->setLibelle($libelle);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("User Added Successfully", Response::HTTP_OK);
        return $view;
    }
    /**
     * @Rest\Delete("/delcategorie/{id}")
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deletecatAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Categorie')
            ->find($request->get('id'));

        $em->remove($user);
        $em->flush();
    }
}
