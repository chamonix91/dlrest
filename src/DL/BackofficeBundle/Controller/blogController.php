<?php

namespace DL\BackofficeBundle\Controller;

use DL\BackofficeBundle \Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class blogController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Post("/addblog/", name="_blog")
     * @param Request $request
     * @return View
     */
    public function addblogAction(Request $request)
    {
        $data = new Blog();
        //var_dump($restresult);die();
        $nom= $request->get('nom');
        $description= $request->get('description');
        $data->setNom($nom);
        $data->setDescription($description);
        $data->setImage1($request->get('image1'));
        $data->setImage2($request->get('image2'));
        $data->setImage3($request->get('image3'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $view = new View("Article Added Successfully", Response::HTTP_OK);
        return $view;
    }
    /**
     * @Rest\Delete("/blog/{id}")
     * @param Request $request
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function deleteblogAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackofficeBundle:Blog')
            ->find($request->get('id'));
        $em->remove($user);
        $em->flush();
    }
    /**
     * @Rest\Get("/blog")
     */
    public function getblogAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLBackofficeBundle:Blog')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restresult;

    }
    /**
     * @Rest\Get("/picblog/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getpicblogAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackofficeBundle:Blog')
            ->find($request->get('id'));
        $photo1= (stream_get_contents($user->getImage1()));
        $photo2= (stream_get_contents($user->getImage2()));
        $photo3= (stream_get_contents($user->getImage3()));
        //var_dump($photo);die();
        return(array('pic1'=>$photo1,'pic2'=>$photo2,'pic3'=>$photo3));
    }
    /**
     * @Rest\Get("/blog/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getblogbyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLBackofficeBundle:Blog')
            ->find($request->get('id'));
        $photo1= (stream_get_contents($user->getImage1()));
        $photo2= (stream_get_contents($user->getImage2()));
        $photo3= (stream_get_contents($user->getImage3()));
        //var_dump($photo);die();
        return(array('pic1'=>$photo1,'pic2'=>$photo2,'pic3'=>$photo3));
    }
}
