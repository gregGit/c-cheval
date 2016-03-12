<?php

namespace Application\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class CcRepriseForm extends AbstractDoctrineFormAjax 
implements FormBsHorizontalProviderInterface
{

    public function __construct(ObjectManager $entityManager)
    {
        parent::__construct($entityManager, 'form-reprise');

        $this->addFieldSetFromEntity('\Application\Entity\CcReprise', true);
    }
    
 
    public function setHorizontalParams()
    {
        $elementsSizes = array(
            'longName' => array(
                "column-size" => "xs-12 col-sm-10 col-md-4",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'name' => array(
                "column-size" => "xs-12 col-sm-10 col-md-4",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'reglement' => array(
                "column-size" => "xs-12 col-sm-10 col-md-4",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'type' => array(
                "column-size" => "xs-12 col-sm-3",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'annee' => array(
                "column-size" => "xs-12 col-sm-2",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'duree' => array(
                "column-size" => "xs-12 col-sm-2",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            ),
            'categorie' => array(
                "column-size" => "xs-12 col-sm-4",
                "label_attributes" => array("class" => "hidden-xs col-sm-2")
            )
        );

        foreach ($elementsSizes as $element => $options) {
            $this->get('reprise')->get($element)->setOptions($options);
        }

        return $this;
    }

}
