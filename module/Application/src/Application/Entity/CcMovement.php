<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation as Form;
use Zend\Form\Annotation\ComposedObject;
use Zend\Form\Annotation\Flags;

/**
 * CcMovement
 *
 * @ORM\Table(name="cc_movement", indexes={@ORM\Index(name="fk_movement_reprise", columns={"reprise"})})
 * @ORM\Entity(repositoryClass="Application\Repository\CcMovementRepository")
 * 
 * @Form\Type("Application\Form\FormMovement")
 * @Form\Name("movement")
 */
class CcMovement
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Form\Attributes({"type":"hidden"})
     * @Form\Filter({"name": "Int"})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="uuid", type="string", length=36, nullable=true)
     * @Form\Attributes({"type":"hidden"})
     */
    private $uuid;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @Form\Attributes({"type":"number", "required":true, "placeholder":"Position", "min":"1", "max":"50", "readonly":"readonly"})
     * @Form\Attributes({"class":"input-sm"})
     * @Form\Options({"label":"Position:"})
     * @Form\Filter({"name": "Int"})
     * @Flags({"priority": 50})
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="coef", type="integer", nullable=false)
     * @Form\Attributes({"type":"number", "required":true, "placeholder":"Coef", "min":"1", "max":"4"})
     * @Form\Attributes({"class":"input-sm"})
     * @Form\Options({"label":"Coefficient:"})
     * @Form\Filter({"name": "Int"})
     * @Flags({"priority": 40})
     */
    private $coef = '1';

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\CcMovementElement", mappedBy="movement", cascade={"persist"})
     * 
     * @ComposedObject({ "target_object":"Application\Entity\CcMovementElement", "is_collection":"true", "options":{"count":1, "should_create_template":true, "allow_add" : true}})
     * @Form\Attributes({"class":"col-xs-10 col-md-5 movement-element"})
     * @Flags({"priority": 30})
     */
    private $elements;

    /**
     * @var string
     *
     * @ORM\Column(name="criteria", type="string", length=500, nullable=true)
     * 
     * @Form\Attributes({"type":"textarea", "required":false, "placeholder":"Critères"})
     * @Form\Attributes({"class":"input-sm  autoexpend"})
     * @Form\Options({"label":"Critères:"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":2000}})
     * @Flags({"priority": 20})
     */
    private $criteria;

    /**
     * @var \Application\Entity\CcReprise
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\CcReprise", inversedBy="movements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reprise", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     * @Form\Attributes({"type":"hidden"})
     * @Form\Filter({"name": "Int"})
     */
    private $reprise;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
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
    
    
    public function addElement(CcMovementElement $element) {
        $this->elements[]=$element;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return CcMovement
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set coef
     *
     * @param integer $coef
     *
     * @return CcMovement
     */
    public function setCoef($coef)
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * Get coef
     *
     * @return integer
     */
    public function getCoef()
    {
        return $this->coef;
    }

    /**
     * Set criteria
     *
     * @param string $criteria
     *
     * @return CcMovement
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * Get criteria
     *
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set reprise
     *
     * @param \Application\Entity\CcReprise $reprise
     *
     * @return CcMovement
     */
    public function setReprise(\Application\Entity\CcReprise $reprise = null)
    {
        $this->reprise = $reprise;

        return $this;
    }

    /**
     * Get reprise
     *
     * @return \Application\Entity\CcReprise
     */
    public function getReprise()
    {
        return $this->reprise;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid = null)
    {
        if (empty($uuid)) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        $this->uuid=$uuid;
        return $this;
    }

    public function __toString()
    {
        $id = $this->getId();
        return "$id";
    }

}
