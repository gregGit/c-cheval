<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * CcReprise
 *
 * @ORM\Table(name="cc_reprise", indexes={@ORM\Index(name="fk_reprise_categorie", columns={"categorie"})})
 * @ORM\Entity(repositoryClass="Application\Repository\CcRepriseRepository")
 * 
 * @ORM\HasLifecycleCallbacks
* 
 * @Form\Type("\Application\Form\Entity\CcRepriseFieldset")
 * @Form\Name("reprise")
 */
class CcReprise 
{
    use Template\Uuid,Template\UpdateAt ;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Form\Attributes({"type":"text"})
     * @Form\Filter({"name": "Int"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * 
     * @Form\Attributes({"type":"text", "required":true, "placeholder":"Nom de la reprise"})
     * @Form\Required(true)
     * @Form\Options({"label":"Nom :"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":100}})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="long_name", type="string", length=2000, nullable=true)
     * 
     * @Form\Attributes({"type":"text", "required":false, "placeholder":"Description de la reprise"})
     * @Form\Options({"label":"Description :"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":2000}})
     */
    private $longName;

    /**
     * @var string
     *
     * @ORM\Column(name="reglement", type="string", length=2000, nullable=true)
     * 
     * @Form\Attributes({"type":"textarea", "required":false, "placeholder":"Conditions/Règlement"})
     * @Form\Attributes({"class":"autoexpend"})
     * @Form\Options({"label":"Condiditions :"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":2000}})
     */
    private $reglement;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1, nullable=false, options={"fixed" = true})
     * 
     * @Form\Type("Zend\Form\Element\Select")
     * @Form\Attributes({"type":"select", "required":false})
     * @Form\Options({"type":"select"})
     * @Form\Options({"label":"Type :"})
     * @Form\Options({"value_options":{"O":"Officielle", "S":"Communauté","P":"Privée"}})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=4,options={"fixed" = true}, nullable=false)
     *
     * @Form\Type("Zend\Form\Element\Number")
     * @Form\Attributes({"required":true, "placeholder":"Année", "min":"1990", "max":"2050"})
     * @Form\Options({"label":"Année :"})
     * @Form\Validator({"name":"Between", "options":{"min":1990, "max":2050}})
     */
    private $annee;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     *
     * @Form\Type("Zend\Form\Element\Number")
     * @Form\Attributes({"required":false, "placeholder":"Durée", "min":"1", "max":"20"})
     * @Form\Required(false)
     * @Form\AllowEmpty(true)
     * @Form\Options({"label":"Durée :"})
     * @Form\Filter({"name": "Int"})
     * @Form\Validator({"name":"IsInt"})
     * @Form\Validator({"name":"Between", "options":{"min":1, "max":20}})
     */
    private $duree;

    /**
     * @var \Application\Entity\CcCategorie
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\CcCategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     * 
     * @Form\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Form\Attributes({"type":"select", "required":false})
     * @Form\Options({"label":"Catégorie :"})
     * @Form\Required(false)
     * @Form\AllowEmpty()
     * @Form\Options({
     *      "label":"Catégorie :",
     *      "empty_option": "Sans Catégorie",
     *      "target_class": "Application\Entity\CcCategorie",
     *      "property": "label"
     * })     
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\CcMovement", mappedBy="reprise")
     * 
     * @Form\Exclude()
     */
    private $movements;
    
    
    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    /**
     * @param Collection $movements
     */
    public function addMovements(Collection $movements)
    {
        foreach ($movements as $movement) {
            $movement->setReprise($this);
            $this->movements->add($tag);
        }
    }

    /**
     * @param Collection $movements
     */
    public function removeMovements(Collection $movements)
    {
        foreach ($movements as $movement) {
            $movement->setReprise(null);
            $this->movements->removeElement($movement);
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CcReprise
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set longName
     *
     * @param string $longName
     *
     * @return CcReprise
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * Get longName
     *
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Set reglement
     *
     * @param string $reglement
     *
     * @return CcReprise
     */
    public function setReglement($reglement)
    {
        $this->reglement = $reglement;

        return $this;
    }

    /**
     * Get reglement
     *
     * @return string
     */
    public function getReglement()
    {
        return $this->reglement;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CcReprise
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return CcReprise
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set duree
     *
     * @param string $duree
     *
     * @return CcReprise
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set categorie
     *
     * @param \Application\Entity\CcCategorie $categorie
     *
     * @return CcReprise
     */
    public function setCategorie(\Application\Entity\CcCategorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Application\Entity\CcCategorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function getMovements()
    {
        return $this->movements;
    }

}
