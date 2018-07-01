<?php

namespace DL\CommissionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DL\BackofficeBundle \Entity \Mlm;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class UserManagerController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    public function getmyinfo($id)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->find($id);
        return $user;
    }

    public function getleftpartner($code)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLBackofficeBundle:Mlm')
                ->findOneByidpartenaire($user->getId());
            if ($mlm != Null)
                return $mlm;
            else
                return Null;
        } else {
            return Null;
        }
    }

    public function getrightpartner($code)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLBackofficeBundle:Mlm')
                ->findOneByidpartenaire($user->getId());
            if ($mlm != Null)
                return $mlm;
            else
                return Null;
        } else {
            return Null;
        }
    }

    /**
     * @Rest\Get("/left/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getleftAction(Request $request)
    {
        set_time_limit(0);
        $lchield = array();
        $flchield = array();
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($request->get('id'));
        if (empty($user->getcodegauche())) {
            return 'pas de gauche';
        }
        $user = $this->getleftpartner($user->getcodegauche());
        if(empty($user->getcodegauche()) || empty($user->getcodedroite())){
            $type ='disponible';
        }else{
            $type = 'indisponible';
        }
        $formatted = [
            'id'=> $this->getmyinfo($user->getIdpartenaire())->getId(),
            'Nom'=> $this->getmyinfo($user->getIdpartenaire())->getNom(),
            'Prénom'=> $this->getmyinfo($user->getIdpartenaire())->getPrenom(),
            'Email' => $this->getmyinfo($user->getIdpartenaire())->getEmail(),
            'possibilité' =>$type,
        ];
        array_push($lchield, $user);
        array_push($flchield, $formatted);
        for ($i = 0; $i < count($lchield); $i++) {
           /* if($i==800){
                break;
            }*/
            if (!empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())
            ) {
                if (!empty($this->getleftpartner($lchield[$i]->getcodegauche())) &&
                    !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                    array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                    array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    if(empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodegauche()) ||
                        empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                    if(empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodegauche()) ||
                        empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            } elseif (!empty($lchield[$i]->getcodegauche()) && empty($lchield[$i]->getcodedroite())) {
                if (!empty($this->getleftpartner($lchield[$i]->getcodegauche()))) {
                    array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                    if(empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodegauche()) ||
                        empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            } elseif (empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())) {
                if (
                !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                    array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    if(empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodegauche()) ||
                        empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted[] = [
                        'id'=> $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            }
        }
        return $flchield;

    }

    /**
     * @Rest\Get("/right/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getrightAction(Request $request)
    {
        set_time_limit(0);
        $lchield = array();
        $flchield = array();
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($request->get('id'));
        if (empty($user->getcodedroite())) {
            return 'pas de droit';
        }
        $user = $this->getrightpartner($user->getcodedroite());
        if(empty($user->getcodegauche()) || empty($user->getcodedroite())){
            $type ='disponible';
        }else{
            $type = 'indisponible';
        }
        $formatted = [
            'id'=> $this->getmyinfo($user->getIdpartenaire())->getId(),
            'Nom' => $this->getmyinfo($user->getIdpartenaire())->getNom(),
            'Prénom' => $this->getmyinfo($user->getIdpartenaire())->getPrenom(),
            'Email' => $this->getmyinfo($user->getIdpartenaire())->getEmail(),
            'possibilité' =>$type,
        ];
        array_push($lchield, $user);
        array_push($flchield, $formatted);
        for ($i = 0; $i < count($lchield); $i++) {
            /*if($i==800){
                break;
            }*/
            if (!empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())
            ) {
                if (!empty($this->getleftpartner($lchield[$i]->getcodegauche())) &&
                    !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                    array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                    array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    if(empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodegauche()) ||
                        empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                    if(empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodegauche()) ||
                        empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            } elseif (!empty($lchield[$i]->getcodegauche()) && empty($lchield[$i]->getcodedroite())) {
                if (!empty($this->getleftpartner($lchield[$i]->getcodegauche()))) {
                    array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                    if(empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodegauche()) ||
                        empty($this->getleftpartner($lchield[$i]->getcodegauche())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getleftpartner($lchield[$i]->getcodegauche())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            } elseif (empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())) {
                if (
                !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                    array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    if(empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodegauche()) ||
                        empty($this->getrightpartner($lchield[$i]->getcodedroite())->getcodedroite())){
                        $type ='disponible';
                    }else{
                        $type = 'indisponible';
                    }
                    $formatted = [
                        'id'=> $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getId(),
                        'Nom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getNom(),
                        'Prénom' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getPrenom(),
                        'Email' => $this->getmyinfo($this->getrightpartner($lchield[$i]->getcodedroite())->getIdpartenaire())->getEmail(),
                        'possibilité' =>$type,
                        ];
                    array_push($flchield, $formatted);
                }
            }
        }
        return $flchield;

    }
}

