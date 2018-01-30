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
 * @ORM\Table(name="revenu")
 * @ORM\Entity(repositoryClass="DL\CommissionBundle\Repository\CommissionRepository")
 */

class Revenu
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
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $iddue;

    /**
 * @return mixed
 */
public function getId()
{
    return $this->id;
}/**
 * @param mixed $id
 */
public function setId($id)
{
    $this->id = $id;
}/**
 * @return mixed
 */
public function getIdpartenaire()
{
    return $this->idpartenaire;
}/**
 * @param mixed $idpartenaire
 */
public function setIdpartenaire($idpartenaire)
{
    $this->idpartenaire = $idpartenaire;
}/**
 * @return mixed
 */
public function getMontant()
{
    return $this->montant;
}/**
 * @param mixed $montant
 */
public function setMontant($montant)
{
    $this->montant = $montant;
}/**
 * @return mixed
 */
public function getDate()
{
    return $this->date;
}/**
 * @param mixed $date
 */
public function setDate($date)
{
    $this->date = $date;
}/**
 * @return mixed
 */
public function getType()
{
    return $this->type;
}/**
 * @param mixed $type
 */
public function setType($type)
{
    $this->type = $type;
}/**
 * @return mixed
 */
public function getIddue()
{
    return $this->iddue;
}/**
 * @param mixed $iddue
 */
public function setIddue($iddue)
{
    $this->iddue = $iddue;
}



}