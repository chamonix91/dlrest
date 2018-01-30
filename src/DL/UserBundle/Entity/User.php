<?php

namespace DL\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 *
 *
 * User
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"code","username"}
 *     )
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $emailenrolleur ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $emaildirect ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $nom ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $prenom ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $cin ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $rib = "";
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $adresse ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $ville = "";
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $pays ;
    /**
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $codepostal ;
    /**
     * @var string
     *
     * @ORM\Column(type="string" ,nullable=true)
     *
     */
    private $code;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $tel;
    /**
     * @ORM\Column(type="blob" ,nullable=true)
     */
    private $ribDocument;
    /**
     * @ORM\Column(type="blob" ,nullable=true)
     */
    private $cinDocument ;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $civilite="";
    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $datedenaissance;
    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $image ;
    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->datedenaissance = new \DateTime('now');
        $this->roles = array('ROLE_NETWORKER');
        $this->enabled = 1;
        $this->code = random_int(25,982776);
    }
    /**
     * @return mixed
     */
    public function getEmailenrolleur()
    {
        return $this->emailenrolleur;
    }
    /**
     * @param mixed $emailenrolleur
     */
    public function setEmailenrolleur($emailenrolleur)
    {
        $this->emailenrolleur = $emailenrolleur;
    }
    /**
     * @return mixed
     */
    public function getEmaildirect()
    {
        return $this->emaildirect;
    }
    /**
     * @param mixed $emaildirect
     */
    public function setEmaildirect($emaildirect)
    {
        $this->emaildirect = $emaildirect;
    }
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
        return $this;
    }
    /**
     * @return mixed
     */
    public function getCivilite()
    {
        return $this->civilite;
    }
    /**
     * @param mixed $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }
    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }
    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }
    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    /**
     * @return mixed
     */
    public function getCin()
    {
        return $this->cin;
    }
    /**
     * @param mixed $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }
    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }
    /**
     * @return mixed
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }
    /**
     * @param mixed $codepostal
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
    }
    /**
     * @return mixed
     */
    public function getDatedenaissance()
    {
        return $this->datedenaissance;
    }
    /**
     * @param mixed $datedenaissance
     */
    public function setDatedenaissance($datedenaissance)
    {
        $this->datedenaissance = $datedenaissance;
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
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }
    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }
    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }
    /**
     * @param mixed $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }
    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /**
     * @return mixed
     */
    public function getRib()
    {
        return $this->rib;
    }
    /**
     * @param mixed $rib
     */
    public function setRib($rib)
    {
        $this->rib = $rib;
    }
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    /**
     * @return mixed
     */
    public function getCinDocument()
    {
        return $this->cinDocument;
    }
    /**
     * @param mixed $cinDocument
     */
    public function setCinDocument($cinDocument)
    {
        $this->cinDocument = $cinDocument;
    }
    /**
     * @return mixed
     */
    public function getRibDocument()
    {
        return $this->ribDocument;
    }
    /**
     * @param mixed $ribDocument
     */
    public function setRibDocument($ribDocument)
    {
        $this->ribDocument = $ribDocument;
    }
}