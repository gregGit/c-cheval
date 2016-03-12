<?php

namespace Application\Form;

use Zend\Form\Form;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

abstract class AbstractCcForm extends Form implements CcFormInterface
{

    private $_em;

    public function setEntityManager($em)
    {
        $this->_em = $em;
    }

    public function getEntityManager()
    {
        return $this->_em;
    }

    public function addButton()
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

    public function updateButton()
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

    public function forUpdate()
    {
        return $this->updateButton();
    }

    public function forInsert()
    {
        return $this->addButton();
    }

    public function setIdentifierField()
    {
        $entity = $this->getObject();
        $meta = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $identifier = $meta->getSingleIdentifierFieldName();
        $fct = 'get' . \Application\Repository\CcAbstractRepository::camelize($identifier);
        $id = $entity->$fct();

        if ($id) {
            $this->add(array(
                'name' => 'rec_key',
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => $id
                ),
            ));
        }
    }

}
