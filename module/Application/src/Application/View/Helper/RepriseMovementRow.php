<?php

namespace Application\View\Helper;

class RepriseMovementRow extends \Zend\View\Helper\AbstractHelper
{

    protected $_position;
    protected $_coef;
    protected $_elements;
    protected $_id;
    protected $_uuid;
    protected $_criteria;

    public function __invoke($movement)
    {
        if ($movement === null) {
            return new self;
        }
        if (is_array($movement)) {
            $this->setFromArray($movement);
        } elseif(is_a($movement, '\Application\Entity\CcMovement')) {
            $this->setId($movement->getId(), $movement->getUuid())
                    ->setPosition($movement->getPosition())
                    ->setElements($movement->getElements())
                    ->setCriteria($movement->getCriteria())
                    ->setCoef($movement->getCoef())
                    
                    ;
        }else {
            $this->setId($movement);
        }

        return $this->getBsRow();
    }

    public function setFromArray(array $movement)
    {
        
    }

    public function renderElements()
    {
        $bsRow = $this->getView()->bs3GridRow();
        foreach ($this->_elements as $element) {
            $bsRow->addCol(array($element['letter'], 2));
            $bsRow->addCol(array($element['label'], 10));
        }
        return $bsRow->render();
    }

    public function getBsRow()
    {
   
        $bsRow = $this->getView()->bs3GridRow()->setOptions(array('attribs' => array('class' => 'reprise-movement')));
        $bsRow->addCol(array($this->_position, 1, null, null,null, array('attribs' => array('class' => "movement-position"))))
                ->addCol(array($this->_coef, 1, null, null,null, array('attribs' => array('class' => "movement-coef"))))
                ->addCol(array($this->renderElements(), array(10, 10, 4), null, null,null, array('attribs' => array('class' => "movement-elements"))))
                ->addCol(array($this->_criteria, array(11, 11, 5), null, null,null, array('attribs' => array('class' => "movement-criteria"))))
                ->addCol(array($this->renderActions(), 1, null, null,null, array('attribs' => array('class' => "movement-actions"))))
                ;
        
        return $bsRow;
        }
        
        
        public function renderActions() {
            $html='';
            $html.=$this->renderButtonEdit();
            $html.=$this->renderButtonDelete();
            return $html;
        }
 public function renderButtonEdit()
    {
        return $this->getView()->bs3Button()
                        ->setAttribs(array(
                            'data-toggle' => 'modal',
                            'data-target'=>'#editMovement',
                            'data-url' => $this->getView()->url('rest-form/movement', array('id' => $this->_id, 'uuid' => $this->_uuid))
                                )
                        )
                        ->setSize(\Bootstrap3\View\Helper\Bs3Button::BTN_SMALL)
                ->link('<i class="fa fa-edit"></i>');
    }
 public function renderButtonDelete()
    {
        return $this->getView()->bs3Button()
                        ->setAttribs(array(
                            'data-role' => 'aj-delete',
                            'data-container'=>'.reprise-movement',
                            'data-url' => $this->getView()->url('rest-movement/rest-full',array('id' => $this->_id, 'uuid' => $this->_uuid))
                                )
                        )
                        ->setSize(\Bootstrap3\View\Helper\Bs3Button::BTN_SMALL)
                ->link('<i class="fa fa-trash"></i>');
    }
        public function render() {
            return $this->getBsRow()->render();
        }
    public function setPosition($position)
    {
        $this->_position = $position;
        return $this;
    }

    public function setCoef($coef)
    {
        $this->_coef = $coef;
        return $this;
    }

    public function setCriteria($criteria)
    {
        $this->_criteria = $criteria;
        return $this;
    }

    public function setElements($elements)
    {
        $this->_elements=array();
        foreach($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    public function addElement($element) {
        if(is_a($element, '\Application\Entity\CcMovementElement')) {
            $this->_elements[]=array(
                'id'=>$element->getId(),
                'position'=>$element->getPosition(),
                'letter'=>$element->getLetter(),
                'label'=>$element->getLabel()
            );
        }
    }
    public function setId($id, $uuid)
    {
        $this->_id = $id;
        $this->_uuid=$uuid;
        return $this;
    }

}
