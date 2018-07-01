<?php

namespace DL\CommissionBundle\Controller;

use DL\BackofficeBundle \Entity\Mlm;
use DL\CommissionBundle\Command\RemunirationCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;


class CommandeController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Rest\Get("/commande")
     */
    public function getAllCommandeAction()
    {
        $restresult = $this->getDoctrine()->getRepository('DLAchatBundle:Commande')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        $mlms = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findBy(array('active'=> 0));

        $commandeinfo = array();
        for($c=0;$c<count($mlms);$c++) {
            $partner = $this->getDoctrine()->getRepository('DLAchatBundle:Commande')
                ->findOneByidpartenaire($mlms[$c]->getId());

            // var_dump($partner);die();
            $verdi = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLUserBundle:User')
                ->findOneBy(array('email' => $mlms[$c]->getEmaildirect()));
            $verenro = $this->get('doctrine.orm.entity_manager')
                ->getRepository('DLUserBundle:User')
                ->findOneBy(array('email' => $mlms[$c]->getEmailenrolleur()));

            if(!empty($verenro)) {
                $mlmenro = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('DLBackofficeBundle:Mlm')
                    ->findOneBy(array('idpartenaire' => $verenro->getId()));
            }else{
                $mlmenro=null;
            }

            if (!empty($partner)) {
                if($mlmenro !=null) {
                    if (!empty($mlmenro->getCodegauche()) && !empty($mlmenro->getCodedroite())) {
                        $intro = [
                            'id' => $mlms[$c]->getId(),
                            'cin' => $mlms[$c]->getCin(),
                            'email' => $mlms[$c]->getEmail(),
                            'direct' => $mlms[$c]->getEmaildirect(),
                            'enrolleur' => $mlms[$c]->getEmailenrolleur(),
                            'prix' => $partner->getMontant(),
                            'datec' => $partner->getDate(),
                            'remarque' => 'enrolleur à déja 2 downline'
                        ];

                        array_push($commandeinfo, $intro);
                    }
                }
            if  (empty($verdi) || empty($verenro)) {
                $intro = [
                    'id' => $mlms[$c]->getId(),
                    'cin' => $mlms[$c]->getCin(),
                    'email' => $mlms[$c]->getEmail(),
                    'direct' => $mlms[$c]->getEmaildirect(),
                    'enrolleur' => $mlms[$c]->getEmailenrolleur(),
                    'prix' => $partner->getMontant(),
                    'datec' => $partner->getDate(),
                    'remarque' => 'enrolleur ou direct non valide'
                ];
                array_push($commandeinfo, $intro);
            }
            else {

                $intro = [
                    'id' => $mlms[$c]->getId(),
                    'cin' => $mlms[$c]->getCin(),
                    'email' => $mlms[$c]->getEmail(),
                    'direct' => $mlms[$c]->getEmaildirect(),
                    'enrolleur' => $mlms[$c]->getEmailenrolleur(),
                    'prix' => $partner->getMontant(),
                    'datec' => $partner->getDate(),
                    'remarque' => 'Inscrit pré à être validé'
                ];
                //}
                array_push($commandeinfo, $intro);
            }

            }else{
                $intro = [
                    'id' => $mlms[$c]->getId(),
                    'cin' => $mlms[$c]->getCin(),
                    'email' => $mlms[$c]->getEmail(),
                    'remarque' => 'pas de commande'
                ];
                array_push($commandeinfo, $intro);
            }



        }

        return $commandeinfo;

    }
    /**
     * @Rest\Get("/commande/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getCommandeByIdAction(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLAchatBundle:Commande')
            ->find($request->get('id'));

        return($user);
    }
    /**
     * @Rest\Get("/vercom/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function getuverbyidAction(Request $request){

        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('DLUserBundle:User')
            ->find($request->get('id'));

        return((stream_get_contents($user->getRibDocument())));
    }
    /**
     * @Rest\Put("/actcommande/{id}")
     * @param Request $request
     * @Rest\View()
     */
    public function ativeAction(Request $request){
        //var_dump(new \DateTime('now'));die();
        $data = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($request->get('id'));
        $em = $this->get('doctrine.orm.entity_manager');
       $user  = $this->get('doctrine.orm.entity_manager')
           ->getRepository('DLUserBundle:User')
           ->find($request->get('id'));
       $user->setActive(1);

        $em->merge($user);
        $em->flush();
        $verdi = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBy(array('email' => $user->getEmaildirect()));
        $verenro = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLUserBundle:User')
            ->findOneBy(array('email' => $user->getEmailenrolleur()));
        $data = new Mlm();
        $data->setIdpartenaire($user->getId());
        $data->setCodedirect($verdi->getCode());
        $data->setCodeparent($verenro->getCode());
        $data->setCodegauche(null);
        $data->setCodedroite(null);
        $data->setPaqueid($user->getPack()->getId());
        //$data->setPaqueid($user->getPack()->getId());

        $data->setAffectation(1);
        $data->setDateaffectation(new \DateTime('now'));




        $em->merge($data);

        $data1 = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DLBackofficeBundle:Mlm')
            ->findOneByidpartenaire($verenro->getId());
        //var_dump($data1);die();
        if(empty($data1->getCodegauche())){
            $data1->setCodegauche($user->getCode());
        }
        else{
            $data1->setCodedroite($user->getCode());
        }
        $em->merge($data1);
        $em->flush();
        $command = new  RemunirationCommand();
        $command->setContainer($this->container);
        $input = new ArrayInput(array('id' => $request->get('id')));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);
        return null;

    }
}
