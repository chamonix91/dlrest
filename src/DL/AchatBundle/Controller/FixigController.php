<?php

namespace DL\AchatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class FixigController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Rest\Get("/walid")
     */
    public function hello(){
        var_dump('hell');die();
        $users = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();

    }
}
