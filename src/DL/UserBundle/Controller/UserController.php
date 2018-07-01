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
        //var_dump($request->get('username'));die();

        $data = new User;
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $enabled = $request->get('enabled');
        $role = $request->get('role');

        $data->setEmail($email);
        $data->setPassword($password);
        $data->setUsername($username);
        $data->setPassword($password);
        $data->setEnabled($enabled);
        $data->setRoles(array($role));

        //var_dump($data);die();
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
    public function putuserAction(Request $request){
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user Place */

        if (empty($user)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }


        $em = $this->get('doctrine.orm.entity_manager');
            $user->setEmail($request->get('email'));
            $user->setUsername($request->get('username'));
            $user->setCin($request->get('cin'));
            $user->setRib($request->get('rib'));
            $user->setNom($request->get('nom'));
            $user->setPrenom($request->get('prenom'));
            $user->setEmailenrolleur($request->get('emailenrolleur'));
            $user->setEmaildirect($request->get('emaildirect'));
            $em->merge($user);
            $em->flush();

       /*migration
        *  $userenrolleur = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBy(array('emailenrolleur' =>$request->get('emailenrolleur')));
        $userdirect = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBy(array('emaildirect' =>$request->get('emaildirect')));
        $usermlm = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:MLM')
            ->findOneBy(array('idpartenaire'=>$request->get('id')));
        $usermlm->setCodeparent($userenrolleur->getCode());
        $usermlm->setCodedirect($userdirect->getCode());
        $usermlmup = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:MLM')
            ->findOneBy(array('idpartenaire'=>$userenrolleur->getId()));
        if(!empty($usermlmup->getCodegauche()) && !empty($usermlmup->getCodegauche())){
            return new View("occupi", Response::HTTP_NOT_FOUND);
        }else{

        }
        $em->merge($usermlm);
        $em->flush();*/


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
    public function getuserbyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLUserBundle:User')
            ->find($request->get('id'));

        return($user);
    }

    /**
     * @Rest\Get("/usercom/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getcombyidAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Panier')
            ->findby(array('idpartenaire' => $request->get('id')));
        $formatted = [];
        $fin =array();
        foreach ($user as $result) {
            $pr = $em->getRepository('DLAchatBundle:Produit')
                ->find($result->getIdproduit());
                $formatted[] = [
                    'libele' => $pr->getLibelle(),
                    'prix' => $pr->getPrix(),
                ];
                array_push($fin,$formatted);
        }
        return($formatted);
    }

    /**
     * @Rest\Get("/user/{mail}/{password}")
     * @param Request $request
     * @Rest\View()
     * @return mixed
     */
    public function loginAction(Request $request){
        $mail=$request->get('mail');
        $pass=$request->get('password');

        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLUserBundle:User')
            ->findOneBy(array('password'=> $pass, 'email' =>$mail));

        $loged=true;
        if(empty($user)){
            $loged=false;
            return(array('role' => 'no','access'=>$loged));
        }
        return(array('role' => $user->getRoles(),'access'=>$loged));
    }






}

