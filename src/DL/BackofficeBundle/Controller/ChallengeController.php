<?php

namespace DL\BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Challenge;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class ChallengeController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/challenge")
     */
    public function getchallengeAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLBackofficeBundle:Challenge')->findAll();
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
        $user = $em->getRepository('DLBackofficeBundle:Challenge')
            ->find($request->get('id'));

        return($user);
    }
    /**
     * @Rest\Post("/challenge/", name="_product")
     * @param Request $request
     * @return View
     */
    public function addAction(Request $request)
    {
        $data = new Challenge();
       $datedebut= $request->get('datedebut');
        $datefin= $request->get('datefin');
        $datedeb = new \DateTime($datedebut);
        $dateenf = new \DateTime($datefin);
        $video = $request->get('videolink');
        //var_dump($date);die();
        $nom =$request->get('nom');
        $description =$request->get('description');
        $logo =$request->get('logo');
        $data->setVideolink($video);
        //var_dump($data);die();
        $data->setDatedebut($datedeb);
       $data->setDatefin($dateenf);
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
    public function logoAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackofficeBundle:Challenge')
            ->find($request->get('id'));
        $photo1= (stream_get_contents($user->getLogo()));
        //var_dump($photo);die();
        return($photo1);
    }
    /**
     * @Rest\Delete("/delchallenge/{id}")
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deletechaAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackofficeBundle:Challenge')
            ->find($request->get('id'));

        $em->remove($user);
        $em->flush();
    }
}
