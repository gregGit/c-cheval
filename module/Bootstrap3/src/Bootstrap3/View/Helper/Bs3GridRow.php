<?php

namespace Bootstrap3\View\Helper;

use Bootstrap3\View\Helper\Bs3AbstractHelper;

class Bs3GridRow extends Bs3AbstractHelper
{

    private $_aCols;

    public function __invoke(array $cols = null)
    {
        $this->_aCols = array();
        if (null === $cols) {
            $that=new self;
            $that->_aCols=array();
            return $that;
        }
        $this->setHelperTag('div')
                ->addHelperAttrib('class', 'row');
        $this->setCols($cols);
        return $this->render();
    }

    public function setCols(array $cols)
    {
        $this->_aCols = array();
        foreach ($cols as $col) {
            $this->addCol($col);
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
    public function addCol($col)
    {
        if (is_a($col, 'Bs3GridCol')) {
            $this->_aCols[] = $col;
            return $this;
        } 
        
        if (is_array($col)) {
            foreach (array('content', 'sizes', 'offsets', 'pushes', 'pulls', 'options') as $index => $key) {
                if (array_key_exists($key, $col)) {
                    $$key = $col[$key];
                } elseif (isset($col[$index])) {
                    $$key = $col[$index];
                } else {
                    $$key = null;
                }
            }
        } else {
            list($content, $sizes, $offsets, $pushes, $pulls, $options)=array($col, null,null,null,null, null);
        }
            $bsCol = new Bs3GridCol();
            $bsCol->setContent($content)
                    ->setSizes($sizes)
                    ->setOffsets($offsets)
                    ->setPushes($pushes)
                    ->setPulls($pulls)
                    ->setOptions($options);
            $this->_aCols[] = $bsCol;
        return $this;
    }

   
    public function render($helperTag = 'div')
    {
                
                ;
        $this->setHelperTag($helperTag)->addHelperAttrib('class', 'row');
        $html = '';
        $html.=$this->openHelperTag();
        $html.=$this->renderCols();
        $html.=$this->closeHelperTag();
        return $html;
    }

    public function renderCols()
    {
        $html = '';
        foreach($this->_aCols as $bsCol) {
            $html.=$bsCol->render();
        }
        return $html;
    }

}
