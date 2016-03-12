<?php

namespace Application\Form;

use Zend\Form\Form;

class FormMovement extends AbstractCcForm implements ModalFormInterface
{

    public function defineHydrators()
    {
        $this->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager(), 'Application\Entity\CcMovement'));
        $this->get('elements')->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager(), 'Application\Entity\CcMovementElement'));
        return $this;
    }

    public function setModal($options = null)
    {
        $labelSize = "xs-2 col-sm-3 col-md-4";
        $colSize = "col-xs-10 col-sm-9 col-md-8";
        $elementsSizes = array(
            'position' => array(
                "column-size" => $colSize,
                "label_attributes" => array("class" => $labelSize)
            ),
            'coef' => array(
                "column-size" => $colSize,
                "label_attributes" => array("class" => $labelSize)
            ),
            'criteria' => array(
                "column-size" => $colSize,
                "label_attributes" => array("class" => $labelSize)
            ),
        );
        $this->get('elements')->setLabel('Elements :');
        return $this->setBsHorizontalSizes($elementsSizes);
    }

//    public function bind($object, $flags = \Zend\Form\FormInterface::VALUES_NORMALIZED)
//    {
//        
//    
//        $f=$this->getFieldsets();
//        
//        foreach($f as $a=>$fs) {
//            $i=$fs->iterator;
//        }
//        $i=$this->iterator;
//        return parent::bind($object, $flags);
//    }

    public function setBsHorizontalSizes(array $elementsSizes = null)
    {
        if (null === $elementsSizes) {
            $elementsSizes = array(
                'position' => array(
                    "column-size" => "xs-1",
                    "label_attributes" => array("class" => "col-sm-1")
                ),
                'coef' => array(
                    "column-size" => "xs-1",
                    "label_attributes" => array("class" => "col-sm-1")
                ),
                'criteria' => array(
                    "column-size" => "xs-12 col-md-5",
                    "label_attributes" => array("class" => "hidden-xs col-sm-2")
                ),
            );
        }
        foreach ($elementsSizes as $element => $options) {
            $this->get($element)->setOptions($options);
        }


        $e = $this->get('elements');

        foreach ($this->getIterator() as $name => $elementOrFieldset) {
            if ($elementOrFieldset instanceof \Zend\Form\Element\Collection) {
                $te = $elementOrFieldset->getTargetElement();
                if (method_exists($te, 'setBsHorizontalSizes')) {
                    $this->get($name)->getTargetElement()->setBsHorizontalSizes();
                }
            }
        }
        return $this;
    }

//    public function setData($data)
//    {
//        if (isset($data['elements']) && is_array($data['elements'])) {
//            foreach ($data['elements'] as $i => $element) {
//                $data['elements'][$i]['position'] = $i + 1;
//                unset($data['elements'][$i]['movement']);
//            }
//        }
//
//        return parent::setData($data);
//    }
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
