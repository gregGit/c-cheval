<?php

namespace Application\View\Helper;

class RepriseRow extends \Zend\View\Helper\AbstractHelper
{

    protected $_name;
    protected $_longname;
    protected $_type;
    protected $_id;
    protected $_categorie;

    public function __invoke($reprise)
    {
        if ($reprise === null) {
            return new self;
        }
        if (is_array($reprise)) {
            $this->setFromArray($reprise);
        } elseif (is_a($reprise, '\Application\Entity\CcReprise')) {
            $this->setId($reprise->getId())
                    ->setType($reprise->getType())
                    ->setName($reprise->getName())
                    ->setLongname($reprise->getLongname())
                    ->setCategorie($reprise->getCategorie())
            ;
        } else {
            $this->setId($reprise);
        }

        return $this->render();
    }

    public function setFromArray(array $reprise)
    {
        
    }

    public function getBsRow()
    {

        $bsRow = $this->getView()->bs3GridRow()->setOptions(array('attribs' => array('class' => 'reprise', 'data-role' => 'aj-delete-container')));
        $bsRow->addCol(array($this->renderName(), array(12, 10), null, null, null, array('attribs' => array('class' => "reprise-name"))))
                ->addCol(array($this->renderActions(), array(12, 2), null, null, null, array('attribs' => array('class' => "reprise-action"))))
        ;

        return $bsRow;
    }

    public function renderName()
    {
        $html = '';
        $html=sprintf('<a class="reprise-name" href="%s" data-id="%d">%s</a>', $this->getView()->url('reprise/edit', array('id'=>$this->_id)), $this->_id, $this->_name);
        return $html;
    }

    public function renderButtonDelete()
    {
        return $this->getView()->bs3Button()
                        ->setAttribs(array(
                            'data-role' => 'aj-delete',
                            'data-id' => $this->_id,
                            'data-action' => $this->getView()->url('rest-reprise')
                                )
                        )
                        ->setSize(\Bootstrap3\View\Helper\Bs3Button::BTN_SMALL)
                ->danger('<i class="fa fa-trash"></i>');
    }
    public function renderButtonPdf()
    {
        return $this->getView()->bs3Button()
                        ->setAttribs(array(
                            'data-role' => 'export-pdf',
                            'data-rec_key' => $this->_id,
                                )
                        )
                        ->setSize(\Bootstrap3\View\Helper\Bs3Button::BTN_SMALL)
                ->normal('<i class="fa fa-file-pdf-o"></i>');
    }

    public function renderActions()
    {
        $html = '';
        $html.=$this->renderButtonDelete();
        $html.=$this->renderButtonPdf();
        return $html;
    }

    public function render()
    {
        return $this->getBsRow()->render();
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function setLongname($name)
    {
        $this->_longname = $name;
        return $this;
    }

    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    public function setCategorie($categorie)
    {
        $this->_categorie = $categorie;
        return $this;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

}
