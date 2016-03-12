<?php

namespace Application\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class AbstractDoctrineForm extends Form
{

    public function __construct(ObjectManager $objectManager, $name)
    {
        parent::__construct($name);

        // The form will hydrate an object of type "BlogPost"
        $this->setHydrator(new DoctrineHydrator($objectManager));

    }

    
    public function addFieldSetFromEntity($entity, $useAsBaseFieldset=false)
    {
        $builder = new AnnotationBuilder();
        if(!is_string($entity)) {
            $entity = new $entity;
        }
        $fieldset = $builder->createForm($entity);
        $fieldset->setUseAsBaseFieldset($useAsBaseFieldset);
        $this->add($fieldset);
        return $this;
    }

}
