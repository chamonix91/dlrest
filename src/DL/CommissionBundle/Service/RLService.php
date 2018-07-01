<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 17/04/2018
 * Time: 16:43
 */

namespace DL\CommissionBundle\Service;
use DL\BackofficeBundle \Entity\Revenu;
use DL\CommissionBundle\Command\leftcommandCommand;
use DL\CommissionBundle\Controller\TreeController;
use DL\UserBundle\DLUserBundle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Validator\Constraints\DateTime;


class RLService
{
    /** @var EntityManager */
    private $em;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function getleftpartner($code)
    {
        $user = $this->em
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->em
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
        $user = $this->em
            ->getRepository('DLUserBundle:User')
            ->findOneBycode($code);
        if ($user) {
            $mlm = $this->em
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

    function getmyleftpartner($lchield,$mlm){
        for ($i = 0; $i < count($lchield); $i++) {

            if (!empty($lchield[$i]) && $lchield[$i]->getIdpartenaire() != $mlm->getIdpartenaire()) {

                if ( !empty($lchield[$i]->getcodegauche()) && !empty($lchield[$i]->getcodedroite())
                ) {
                    if (!empty($this->getleftpartner($lchield[$i]->getcodegauche())) &&
                        !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                        array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                        array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    }
                } elseif (!empty($lchield[$i]->getcodegauche()) &&  empty($lchield[$i]->getcodedroite())) {
                    if (!empty($this->getleftpartner($lchield[$i]->getcodegauche()))) {
                        array_push($lchield, $this->getleftpartner($lchield[$i]->getcodegauche()));
                    }
                } elseif ( empty($lchield[$i]->getcodegauche()) &&  !empty($lchield[$i]->getcodedroite())) {
                    if (
                    !empty($this->getrightpartner($lchield[$i]->getcodedroite()))) {
                        array_push($lchield, $this->getrightpartner($lchield[$i]->getcodedroite()));
                    }
                }
            }
        }
        return $lchield;
    }
    function getmyrightpartner($rchield,$mlm){
        for ($i = 0; $i < count($rchield); $i++) {
            if (!empty($rchield[$i]) && $rchield[$i]->getIdpartenaire() != $mlm->getIdpartenaire()) {

                //if ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {
                if ( !empty($rchield[$i]->getcodegauche()) && !empty($rchield[$i]->getcodedroite())) {
                    if (!empty($this->getleftpartner($rchield[$i]->getcodegauche())) &&
                        !empty($this->getrightpartner($rchield[$i]->getcodedroite()))) {
                        array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                        array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));
                    }

                    //} elseif ($rchield[$i]->getcodegauche() != 'NULL' && !($rchield[$i]->getcodedroite() == 'NULL')) {
                } elseif ( !empty($rchield[$i]->getcodegauche()) && empty($rchield[$i]->getcodedroite())) {
                    if (!empty($this->getleftpartner($rchield[$i]->getcodegauche()))) {
                        array_push($rchield, $this->getleftpartner($rchield[$i]->getcodegauche()));
                    }
                    //} elseif ($rchield[$i]->getcodegauche() == 'NULL' && !($rchield[$i]->getcodedroite() != 'NULL')) {
                } elseif ( empty($rchield[$i]->getcodegauche()) && !empty($rchield[$i]->getcodedroite())) {
                    if (!empty($this->getrightpartner($rchield[$i]->getcodedroite()))) {
                        array_push($rchield, $this->getrightpartner($rchield[$i]->getcodedroite()));
                    }
                }
            }
        }
        return $rchield;
    }

}