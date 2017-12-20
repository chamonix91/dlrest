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
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="string")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string")
     */
    private $image1;

    /**
     * @ORM\Column(type="string")
     */
    private $image2;

    /**
     * @ORM\Column(type="string")
     */
    private $image3;


    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="string")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string")
     */
    private $souscategorie;


}