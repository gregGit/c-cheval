<?php

namespace Application\Entity\Template;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * UpdateAt
 * 
 * @ORM\HasLifecycleCallbacks
 */
trait UpdateAt
{

    /**
     * @var \DateTime
     * @ORM\Column(name="updateat", type="datetime", nullable=true)
     * @Form\Exclude()
     */
    protected $updateat;

    public function getUpdateat()
    {
        return $this->updateat;
    }

    /**
     * @ORM\PrePersist
     */
    public function setTimestamp()
    {
        $this->updateat = new \DateTime();
        return $this;
    }

}
