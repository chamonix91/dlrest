<?php

namespace DL\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Challenge;

class ChallengeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/challenge")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLBackoffice:Challenge')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    /**
     * @Rest\Get("/challenge/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getbyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackoffice:Challenge')
            ->find($request->get('id'));

        return($user);
    }
    /**
     * @Rest\Post("/challenge/", name="_product")
     * @param Request $request
     * @return View
     */
    public function imgAction(Request $request)
    {
        $data = new Challenge();
        $datedebut= $request->get('datedebut');
        $datefin= $request->get('datefin');
        $nom =$request->get('nom');
        $description =$request->get('description');
        $logo =$request->get('logo');
        //var_dump($data);die();
        $data->setDatedebut($datedebut);
        $data->setDatefin($datefin);
        $data->setNom($nom);
        $data->setDescription($description);
        $data->setLogo($logo);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("User Added Successfully", Response::HTTP_OK);
        return $view;
    }
    /**
     * @Rest\Get("/logochallenge/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getbypicAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackoffice:Challenge')
            ->find($request->get('id'));
        $photo1= (stream_get_contents($user->getLogo()));
        //var_dump($photo);die();
        return($photo1);
    }

}
