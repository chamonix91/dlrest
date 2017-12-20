<?php

namespace DL\AchatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DLAchatBundle:Default:index.html.twig');
    }
}
