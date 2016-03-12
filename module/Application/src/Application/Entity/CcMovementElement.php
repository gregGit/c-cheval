<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use Zend\Form\Annotation\Flags;

/**
 * CcMovementElement
 *
 * @ORM\Table(name="cc_movement_element", indexes={@ORM\Index(name="fk_element_movement", columns={"movement"})})
 * @ORM\Entity(repositoryClass="Application\Repository\CcMovementElementRepository")
 * @Form\Name("movement_element")
 * @Form\Type("Application\Form\FormMovementElement")
 */
class CcMovementElement
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
     * @ORM\Column(name="position", type="integer", nullable=false)
     * @Form\Attributes({"type":"hidden"})
     * @Form\Filter({"name": "Int"})
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="letter", type="string", length=3, nullable=false)
     * @Form\Attributes({"type":"text", "required":true})
     * @Form\Attributes({"class":"input-sm"})
     * @Form\Options({"label":"Lettre:"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Filter({"name": "StringToUpper", "options":{"encoding" : "UTF-8"}})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":3}})
     * @Flags({"priority": 100})
     */
    private $letter;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Form\Attributes({"type":"text", "required":true})
     * @Form\Options({"label":"Libellé:"})
     * @Form\Attributes({"class":"input-sm"})
     * @Form\Filter({"name": "StripTags"})
     * @Form\Filter({"name": "StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"encoding" : "UTF-8","min":1, "max":100}})
     * @Flags({"priority": 50})
     */
    private $label;

    /**
     * @var \Application\Entity\CcMovement
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\CcMovement", inversedBy="elements")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movement", referencedColumnName="id", onDelete="CASCADE")
     * })
     * @Form\Attributes({"type":"hidden"})
     * @Form\Filter({"name": "Int"})
     */
    private $movement;

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
     * Set position
     *
     * @param integer $position
     *
     * @return CcMovementElement
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
     * Set letter
     *
     * @param string $letter
     *
     * @return CcMovementElement
     */
    public function setLetter($letter)
    {
        $this->letter = strtoupper($letter);

        return $this;
    }

    /**
     * Get letter
     *
     * @return string
     */
    public function getLetter()
    {
        return $this->letter;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return CcMovementElement
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set movement
     *
     * @param \Application\Entity\CcMovement $movement
     *
     * @return CcMovementElement
     */
    public function setMovement(\Application\Entity\CcMovement $movement = null)
    {
        $this->movement = $movement;

        return $this;
    }

    /**
     * Get movement
     *
     * @return \Application\Entity\CcMovement
     */
    public function getMovement()
    {
        return $this->movement;
    }

}
