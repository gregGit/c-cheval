<?php

namespace Application\Form;

use Zend\Form\Form;

class FormMovementElement extends \Zend\Form\Fieldset
{
 
    public function setBsHorizontalSizes(array $elementsSizes = null)
    {
        if (null === $elementsSizes) {
            $elementsSizes = array(
                'position' => array(
                    "column-size" => "xs-1",
                    "label_attributes" => array("class" => "col-sm-1")
                ),
                'letter' => array(
                    "column-size" => "xs-2",
                    "label_attributes" => array("class" => "col-sm-1")
                ),
                'label' => array(
                    "column-size" => "xs-3 col-md-4",
                    "label_attributes" => array("class" => "col-xs-10 col-sm-10")
                ),
            );
        }
        foreach ($elementsSizes as $element => $options) {
            $this->get($element)->setOptions($options);
        }

        return $this;
    }

   
//
//    public function getListCategories() {
//        return $this->getEntityManager()->getRepository('Application\Entity\CcCategorie')->findForSelect();
//    }
//     public function getStandardForm() {
//         
//        $this->get('categorie')->setValueOptions($this->getListCategories())->setOption('value_options', $this->getListCategories());
//        return $form;
//     }
//    
//    /**
//     * Formulaire d'ajout
//     */
//    public function getNewForm(){
//        return false;
//    }
//    
//        /**
//     * Formulaire de modidification
//     */
//    public function getEditForm(){
//        
//    }
//
//    
//    public function setBsParams() {
////             * @Form\Options({"column-size":"xs-12 col-sm-10 col-md-4","label_attributes":{"class":"hidden-xs col-sm-2"}})
//;
//    }    
//        public function formReprise()
//    {
//
//    }
//
//    public function newReprise()
//    {
//        $form = $this->formReprise();
//        $form->add(array(
//            'name' => 'submit',
//            'attributes' => array(
//                'type' => 'submit',
//                'value' => 'Ajouter',
//                'id' => 'submitbutton',
//            ),
//        ));
//        return $form;
//    }
//
//    public function modifyReprise($elem)
//    {
//        $form = $this->formReprise();
//        $form->add(array('name'=>'id', 
//            'attributes' => array(
//                'type' => 'hidden',
//                'value' => $elem->getId()
//            )));
//        $form->add(array(
//            'name' => 'submit',
//            'attributes' => array(
//                'type' => 'submit',
//                'value' => 'Modifier',
//                'id' => 'submitbutton',
//            ),
//        ));
//
//        $form->bind($elem);
//        return $form;
//    }
}
