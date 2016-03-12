<?php

namespace Application\Form\Entity;

use Zend\Form\Fieldset;
use Application\Entity\CcReprise;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class CcRepriseFieldset extends Fieldset implements \Zend\InputFilter\InputFilterProviderInterface
{
   public function getInputFilterSpecification()
    {
        if (isset($this->input_filter_factory)){
            return $this->input_filter_factory;
        }        
    }
}
