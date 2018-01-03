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
    public function getMontantmin()
    {
        return $this->montantmin;
    }

    /**
     * @param mixed $montantmin
     */
    public function setMontantmin($montantmin)
    {
        $this->montantmin = $montantmin;
    }

    /**
     * @return mixed
     */
    public function getMontantmax()
    {
        return $this->montantmax;
    }

    /**
     * @param mixed $montantmax
     */
    public function setMontantmax($montantmax)
    {
        $this->montantmax = $montantmax;
    }

    /**
     * @return mixed
     */
    public function getPlafond()
    {
        return $this->plafond;
    }

    /**
     * @param mixed $plafond
     */
    public function setPlafond($plafond)
    {
        $this->plafond = $plafond;
    }







}