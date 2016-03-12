<?php

namespace Application\Entity\Template;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Uuid
 * 
 * @ORM\HasLifecycleCallbacks
 */
trait  Uuid
{

    /**
     * @var integer
     *
     * @ORM\Column(name="uuid", type="string", length=36, nullable=true)
     * @Form\Attributes({"type":"hidden"})
     */
    protected $uuid;

    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDefaultUuid() {
        if(empty($this->getUuid())) {
            $this->setUuid();
        }
    }
    public function setUuid($uuid = null)
    {
        if (empty($uuid)) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        $this->uuid = $uuid;
        return $this;
    }

}
