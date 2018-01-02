<?php

namespace DL\UserBundle\Controller;

use DL\UserBundle\DLUserBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use DL\UserBundle\Entity\User;

class UserController extends FOSRestController
{



    // liste tous les utilisateurs ici

    /**
     * @Rest\Get("/user", name="_allusers")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }

    // Ajouter Utilisateurs Ici

    /**
     * @Rest\Post("/user/", name="_user")
     * @param Request $request
     * @return View
     */

    public function postAction(Request $request)
    {
        $data = new User;
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $passwordr = $request->get('passwordr');
        $enabled = $request->get('enabled');
        if(empty($email) || empty($password)|| empty($username)|| empty($passwordr)|| empty($enabled))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setEmail($email);
        $data->setPassword($password);
        $data->setUsername($username);
        $data->setPassword($passwordr);
        $data->setEnabled($enabled);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("User Added Successfully", Response::HTTP_OK);

        return $view;
 }






}

