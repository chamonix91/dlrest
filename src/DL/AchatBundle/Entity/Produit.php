<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 12/12/2017
 * Time: 11:35
 */

namespace DL\AchatBundle \Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="produit")
 */
class Produit
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $libelle;

    /**
     * @var blob
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image1;

    /**
     * @var blob
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image2;

    /**
     * @var blob
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image3;


    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $shortdescription;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

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
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return blob
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * @param blob $image1
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;
    }

    /**
     * @return blob
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param blob $image2
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
    }

    /**
     * @return blob
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * @param blob $image3
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }

    /**
     * @param mixed $shortdescription
     */
    public function setShortdescription($shortdescription)
    {
        $this->shortdescription = $shortdescription;
    }


    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }




}