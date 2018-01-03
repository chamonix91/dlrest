<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 11/12/2017
 * Time: 15:28
 */

namespace DL\AchatBundle \Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="achat")
 */

class Achat
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $idpartenaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateconfirmation;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string")
     */
    private $type="";

    /**
     * Achat constructor.
     */
    public function __construct()
    {
        $this->datecreation = new \DateTime('now');
        $this->dateconfirmation = new \DateTime('now');

    }


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
    public function getDateconfirmation()
    {
        return $this->dateconfirmation;
    }

    /**
     * @param mixed $dateconfirmation
     */
    public function setDateconfirmation($dateconfirmation)
    {
        $this->dateconfirmation = $dateconfirmation;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



}