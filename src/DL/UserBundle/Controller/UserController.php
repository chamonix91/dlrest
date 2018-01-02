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


    /**
     * @Rest\Get("/user")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }


        return $restresult;
    }

    /**
     * @Rest\Post("/user/")
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        /*var_dump($request);
        die();*/
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

    /**
     * @Rest\Put("/user/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function putAction(Request $request){
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user Place */

        if (empty($user)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }


        $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            /*$email = $request->get('email');
            var_dump($request->get('email'));
            die();*/
           // $user->setEmail("sami@gmail.com");
            $user->setEmail($request->get('email'));
            $user->setUsername($request->get('username'));
            $em->merge($user);
            $em->flush();
            return $user;

    }

    /**
     * @Rest\Delete("/user/{id}")
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLUserBundle:User')
            ->find($request->get('id'));

        $em->remove($user);
        $em->flush();
    }

    /**
     * @Rest\Get("/user/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getbyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLUserBundle:User')
            ->find($request->get('id'));

        return($user);
    }





}

