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
 * @ORM\Table(name="due")
 */

class Due
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $codegauche1;

    /**
     * @ORM\Column(type="string")
     */
    private $codegauche2;

    /**
     * @ORM\Column(type="string")
     */
    private $codedroite1;

    /**
     * @ORM\Column(type="string")
     */
    private $codedroite2;



}