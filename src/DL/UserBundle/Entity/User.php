<?php
namespace DL\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $plainPassword;

    /**
     * @ORM\Column(type="string" ,nullable=true)
     */
    private $nom="";

    /**
     * @ORM\Column(type="string")
     */
    private $prenom="";

    /**
     * @ORM\Column(type="string")
     */
    private $cin="";

    /**
     * @ORM\Column(type="string")
     */
    private $rib="";

    /**
     * @ORM\Column(type="string")
     */
    private $adresse="";

    /**
     * @ORM\Column(type="string")
     */
    private $ville="";

    /**
     * @ORM\Column(type="string")
     */
    private $pays="";

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal= 0;

    /**
     * @ORM\Column(type="string")
     */
    private $code="";

    /**
     *
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $datedenaissance;

    /**
     * @ORM\Column(type="string")
     */
    private $image="";

    /**
     * User constructor.
     *
     */
    public function __construct()
    {
        $this->datedenaissance = new \DateTime('now');
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
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
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





}