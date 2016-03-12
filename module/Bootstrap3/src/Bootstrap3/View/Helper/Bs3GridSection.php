<?php

namespace Bootstrap3\View\Helper;

use Bootstrap3\View\Helper\Bs3AbstractHelper;

class Bs3GridSection extends Bs3AbstractHelper
{

    protected $_tag;
    protected $_containerCol = 12;
    private $_aRows;

    public function __invoke($rows = null, $options = null)
    {

        $this->_tag = 'section';
        $this->setOptions($options)
                ->setHelperTag($this->_tag)
        ;
        $this->_aRows = array();

        if (null === $rows) {
            $that = new self;
            $that->_tag = 'section';
            $that->setOptions($options)
                    ->setHelperTag($this->_tag)
            ;
            $that->_aRows = array();
            return $that;
        }
        $this->setRows($rows);
        return $this->render();
    }

    public function setRows(array $rows)
    {
        $this->_aRows = array();
        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }

    /**
     * $col peut être :
     * _ un tableau :
     * array(
     * 'content'=>contenu
     * 'attribs'=>array(name=>value, ...),
     * 'sizes'=>array('xs'=>val, ...) OU array(xs, sm, lg, md)
     * 'offsets'=>array('xs'=>val, ...) OU array(xs, sm, lg, md)
     * 
     * _ un objet Bs3GridCol
     * _ une chaine 
     * @param type $col
     */
    public function addRow($row, $options = null)
    {
        if (is_a($row, 'Bootstrap3\View\Helper\Bs3GridRow')) {
            $this->_aRows[] = $row;
        } else {
            $bsRow = new Bs3GridRow();
            if (null !== $options) {
                $bsRow->setOptions($options);
            }
            $bsRow->setCols($row);
            $this->_aRows[] = $bsRow;
            ;
        }
        return $this;
    }

    public function addRowValign($row)
    {
        return $this->addRow($row, array('attribs' => array('class' => 'vertical-align')));
    }

    public function render($helperTag = 'section')
    {
        $this->_tag = $helperTag;
        $this->setHelperTag($this->_tag);
        $html = '';
        $html.=$this->openHelperTag();
        foreach ($this->_aRows as $row) {
            $html.=$row->render();
        }
        $html.=$this->closeHelperTag();
        return $html;
    }

}
