<?php
namespace Application\Form;
use Zend\Form\FieldsetInterface;
Class EntityFormFactory extends \Zend\Form\Factory {
     public function configureFieldset(FieldsetInterface $fieldset, $spec)
    {
       $fieldset=parent::configureFieldset($fieldset, $spec);

        $fieldset->input_filter_factory= $spec['input_filter'];
        return $fieldset;
    }
}