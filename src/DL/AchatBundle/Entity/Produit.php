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
     * @ORM\ManyToOne(targetEntity="DL\AchatBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="idcategory", referencedColumnName="id", onDelete="CASCADE")
     */
    private $idcategory;

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
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $categorie;


    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $souscategorie;

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
    public function getIdcategory()
    {
        return $this->idcategory;
    }

    /**
     * @param mixed $idcategory
     */
    public function setIdcategory($idcategory)
    {
        $this->idcategory = $idcategory;
    }







    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * @param mixed $image1
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;
    }

    /**
     * @return mixed
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param mixed $image2
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
    }

    /**
     * @return mixed
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * @param mixed $image3
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;
    }

    /**
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return mixed
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }

    /**
     * @param mixed $souscategorie
     */
    public function setSouscategorie($souscategorie)
    {
        $this->souscategorie = $souscategorie;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }




}