<?php

namespace DL\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DLBackofficeBundle:Default:index.html.twig');
    }
}
