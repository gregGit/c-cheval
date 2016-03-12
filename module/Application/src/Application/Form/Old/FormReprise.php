<?php

namespace Application\Form;

use Zend\Form\Form;

class FormReprise extends AbstractCcForm
{
    
    public function setBsHorizontalSizes(array $elementsSizes = null)
    {
        if (null === $elementsSizes) {
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
                    "column-size" => "xs-12 col-sm-3",
                    "label_attributes" => array("class" => "hidden-xs col-sm-2")
                ),
                'categorie' => array(
                    "column-size" => "xs-12 col-sm-3",
                    "label_attributes" => array("class" => "hidden-xs col-sm-2")
                )
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
