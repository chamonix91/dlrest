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
    private $idproduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $idpartenaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

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
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * @param mixed $idproduit
     */
    public function setIdproduit($idproduit)
    {
        $this->idproduit = $idproduit;
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



}