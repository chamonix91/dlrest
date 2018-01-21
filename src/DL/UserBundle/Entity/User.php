<?php

namespace DL\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 *
 * User
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="DL\BackofficeBundle\Entity\Mlm", cascade={"persist"})
     * @ORM\JoinColumn(name="mlm_id", referencedColumnName="id")
     * @Assert\Type(type="DL\UserBundle\Entity\Mlm")
     * @Assert\Valid()
     *
     */
    private $Mlm ;


    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $nom  ;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $prenom ;

    /**
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $cin ;

    /**
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $rib ;

    /**
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $adresse ;

    /**
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $ville;

    /**
     *
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $pays;

    /**
     *
     * @var integer
     * @ORM\Column(type="integer" ,nullable=true)
     */
    private $codepostal ;

    /**
     *
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $code ;

    /**
     * @var integer
     *
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $tel;

    /**
     * @var string
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $civilite ;

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $datedenaissance;

    /**
     * @ORM\Column(type="blob" ,nullable=true)
     */
    private $image ;

    /**
     * @var blob
     * @ORM\Column(type="blob" ,nullable=true)
     */
    private $ribDocument ;

    /**
     *
     *  @var blob
     * @ORM\Column(type="blob" ,nullable=true)
     */
    private $cinDocument ;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    protected $facebook_id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", nullable=true)
     */
    protected $google_id;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string", nullable=true)
     */
    protected $twitter_id;



    /**
     * User constructor.
     *
     */
    public function __construct()
    {
        $this->datedenaissance = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getMlm()
    {
        return $this->Mlm;
    }

    /**
     * @param mixed $Mlm
     */
    public function setMlm($Mlm)
    {
        $this->Mlm = $Mlm;
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param string $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param string $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * @param string $twitter_id
     */
    public function setTwitterId($twitter_id)
    {
        $this->twitter_id = $twitter_id;
    }


}