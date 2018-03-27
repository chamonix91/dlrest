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
 * @ORM\Table(name="commande")
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $idpartenaire;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="float")
     */
    private $montant;
    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;
    /**
     * Commande constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime('now');
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
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }
}