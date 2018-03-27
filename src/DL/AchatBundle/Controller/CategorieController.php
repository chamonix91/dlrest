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
        /*
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Categorie')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;*/
        $users = $this->getDoctrine()->getRepository('DLUserBundle:User')->findAll();
       // var_dump($users[6478]->getEmail());die();
        $final = array();
        for($c=0;$c<count($users);$c++){
        //for($c=6477;$c<count($users);$c++){
            $partner = $this->getDoctrine()->
            getRepository('DLAchatBundle:DreamlifePartnerPartner')
                ->findOneBycode($users[$c]->getCode());
            if(!empty($partner)&& !empty($this->getmyparentcode($partner->getUserUid()->getUid()-1))){
               // var_dump($c);
            if($this->getnature($partner->getUserUid()->getUid()-1)==2){
                $intro = [
                    'idpartenaire'=>$users[$c]->getId(),
                    'codeparent'=>$this->getmyparentcode($partner->getUserUid()->getUid()-1)->getCode(),
                    'codedirect'=>$this->getmyenrollercode($partner->getUserUid()->getUid()-1)->getCode(),
                    'codegauche'=>$this->getmychield($partner->getUserUid()->getUid()-1)[0]->getCode(),
                    'codedroite'=>$this->getmychield($partner->getUserUid()->getUid()-1)[1]->getCode(),
                    'paque'=>$partner->getPackId()
                ];
            }elseif ($this->getnature($partner->getUserUid()->getUid()-1)==1){
                $intro = [
                    'idpartenaire'=>$users[$c]->getId(),
                    'codeparent'=>$this->getmyparentcode($partner->getUserUid()->getUid()-1)->getCode(),
                    'codedirect'=>$this->getmyenrollercode($partner->getUserUid()->getUid()-1)->getCode(),
                    'codegauche'=>$this->getmychield($partner->getUserUid()->getUid()-1)[0]->getCode(),
                    'paque'=>$partner->getPackId()
                ];
            }else{
                $intro = [
                    'idpartenaire'=>$users[$c]->getId(),
                    'codeparent'=>$this->getmyparentcode($partner->getUserUid()->getUid()-1)->getCode(),
                    'codedirect'=>$this->getmyenrollercode($partner->getUserUid()->getUid()-1)->getCode(),
                    'paque'=>$partner->getPackId()
                ];
            }
                array_push($final,$intro);
        }


        }
        return $final;
    }
    public function getmychield($i)
    {

        $neuds = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:DreamlifePartnerPartner')
            ->findBytreeParentId($i);
        if(!empty($neuds))
        return $neuds;
        else
            return null;
    }
    public function getnature($i)
    {

        $neuds = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLAchatBundle:DreamlifePartnerPartner')
            ->findBytreeParentId($i);
        $x=0;
        foreach ($neuds as $neut) {
            $x++;
        }
        return $x;
    }
    public function getmyparentcode($i){
        $partner = $this->getDoctrine()->
        getRepository('DLUserBundle:User')
            ->find($i);
        return $partner;
    }
    public function getmyenrollercode($i){
        $partner = $this->getDoctrine()->
        getRepository('DLUserBundle:User')
            ->find($i);
        return $partner;
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
