<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 11/12/2017
 * Time: 15:28
 */

namespace DL\BackofficeBundle \Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mlm")
 * @ORM\Entity(repositoryClass="DL\CommissionBundle\Repository\MlmRepository")
 */
class Mlm
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $idpartenaire;

    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $codeparent;


    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $codedirect;

    /**
     * @var integer
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $paqueid;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $datecreation;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $dateaffectation;

    /**
     * @var boolean
     * @ORM\Column(type="boolean" ,nullable=true)
     */
    private $affectation;

    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $codegauche;

    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $codedroite;


    /**
     * @var boolean
     * @ORM\Column(type="boolean" ,nullable=true)
     */
    private $active;

    /**
     * @var integer
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $nbrepartenairegauche;

    /**
     *
     * @var integer
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $nbrepartenairedroite;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdpartenaire()
    {
        return $this->idpartenaire;
    }

    /**
     * @param mixed $idpartenaire
     */
    public function setIdpartenaire($idpartenaire)
    {
        $this->idpartenaire = $idpartenaire;
    }

    /**
     * @return mixed
     */
    public function getCodeparent()
    {
        return $this->codeparent;
    }

    /**
     * @param mixed $codeparent
     */
    public function setCodeparent($codeparent)
    {
        $this->codeparent = $codeparent;
    }

    /**
     * @return mixed
     */
    public function getCodedirect()
    {
        return $this->codedirect;
    }

    /**
     * @param mixed $codedirect
     */
    public function setCodedirect($codedirect)
    {
        $this->codedirect = $codedirect;
    }

    /**
     * @return mixed
     */
    public function getPaqueid()
    {
        return $this->paqueid;
    }

    /**
     * @param mixed $paqueid
     */
    public function setPaqueid($paqueid)
    {
        $this->paqueid = $paqueid;
    }

    /**
     * @return mixed
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param mixed $datecreation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }

    /**
     * @return mixed
     */
    public function getDateaffectation()
    {
        return $this->dateaffectation;
    }

    /**
     * @param mixed $dateaffectation
     */
    public function setDateaffectation($dateaffectation)
    {
        $this->dateaffectation = $dateaffectation;
    }

    /**
     * @return mixed
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

    /**
     * @param mixed $affectation
     */
    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;
    }

    /**
     * @return mixed
     */
    public function getCodegauche()
    {
        return $this->codegauche;
    }

    /**
     * @param mixed $codegauche
     */
    public function setCodegauche($codegauche)
    {
        $this->codegauche = $codegauche;
    }

    /**
     * @return mixed
     */
    public function getCodedroite()
    {
        return $this->codedroite;
    }

    /**
     * @param mixed $codedroite
     */
    public function setCodedroite($codedroite)
    {
        $this->codedroite = $codedroite;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getNbrepartenairegauche()
    {
        return $this->nbrepartenairegauche;
    }

    /**
     * @param mixed $nbrepartenairegauche
     */
    public function setNbrepartenairegauche($nbrepartenairegauche)
    {
        $this->nbrepartenairegauche = $nbrepartenairegauche;
    }

    /**
     * @return mixed
     */
    public function getNbrepartenairedroite()
    {
        return $this->nbrepartenairedroite;
    }

    /**
     * @param mixed $nbrepartenairedroite
     */
    public function setNbrepartenairedroite($nbrepartenairedroite)
    {
        $this->nbrepartenairedroite = $nbrepartenairedroite;
    }




}