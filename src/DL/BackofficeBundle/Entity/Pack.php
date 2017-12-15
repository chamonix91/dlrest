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
 * @ORM\Table(name="pack")
 */

class Pack
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montantmin;

    /**
     * @ORM\Column(type="float")
     */
    private $montantmax;

    /**
     * @ORM\Column(type="float")
     */
    private $plafond;





}