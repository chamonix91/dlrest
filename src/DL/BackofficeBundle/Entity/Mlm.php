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
     * @ORM\Column(type="integer")
     */
    private $idpartenaire;

    /**
     * @ORM\Column(type="string")
     */
    private $codeparent;


    /**
     * @ORM\Column(type="string")
     */
    private $codedirect;

    /**
     * @ORM\Column(type="integer")
     */
    private $paqueid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateaffectation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $affectation;

    /**
     * @ORM\Column(type="string")
     */
    private $codegauche;

    /**
     * @ORM\Column(type="string")
     */
    private $codedroite;


    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrepartenairegauche;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrepartenairedroite;


}