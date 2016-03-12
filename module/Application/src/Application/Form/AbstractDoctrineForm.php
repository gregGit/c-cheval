<?php

namespace Application\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Zend\Form\Form;

class AbstractDoctrineForm extends Form
{

    private $_em;

    public function __construct(ObjectManager $entityManager, $name)
    {
        parent::__construct($name);

        $this->_em = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager));
        $this->setAttribute('method', 'POST');
    }

    public function addFieldSetFromEntity($entity, $useAsBaseFieldset = false)
    {
        $builder = new AnnotationBuilder($this->_em);
        $builder->setFormFactory(new EntityFormFactory());
        if (is_string($entity)) {
            $entity = new $entity;
        }
        $fieldset = $builder->createForm($entity);
        $fieldset->setHydrator(new DoctrineHydrator($this->_em));
        $fieldset->setUseAsBaseFieldset($useAsBaseFieldset);
        $this->add($fieldset);
        return $this;
    }

    public function addCreateButton()
    {
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Ajouter',
                'id' => 'submitbutton',
            ),
        ));

        return $this;
    }

    public function addUpdateButton()
    {
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Modifier',
                'id' => 'submitbutton',
            ),
        ));

        return $this;
    }
}
