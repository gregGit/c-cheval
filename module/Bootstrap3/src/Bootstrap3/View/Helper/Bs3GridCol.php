<?php

namespace Bootstrap3\View\Helper;

use Bootstrap3\View\Helper\Bs3AbstractHelper;

class Bs3GridCol extends Bs3AbstractHelper
{

    protected $_content;
    protected $_sizes;
    protected $_offsets;
    protected $_pushes;
    protected $_pulls;
            
    
    public function __invoke($content=null, $sizes=null, $offsets=null, $pushes=null, $pulls=null)
    {
        $this->setHelperTag('div');
        $this->_sizes=null;
        $this->_offsets=null;
        $this->_pushes=null;
        $this->_pulls=null;
        if(null===$content) {
            return new self;
        }
        $this->setContent($content)
                ->setSizes($sizes)
                ->setOffsets($offsets)
                ->setPushes($pushes)
                ->setPulls($pulls)
                ;
        
        return $this->render();
        
    }
    public function setSizes($sizes) {
        return $this->setOption('sizes', self::arraySizes($sizes));
    }
    public function setOffsets($offsets) {
        return $this->setOption('offsets', self::arraySizes($offsets, 'offset'));
    }
    public function setPushes($pushes) {
        return $this->setOption('pushes', self::arraySizes($pushes, 'push'));
    }
    public function setPulls($pulls) {
        return $this->setOption('pulls', self::arraySizes($pulls, 'pull'));
    }
    
   
    public static function arraySizes($sizes, $tag=null) {
        if(empty($sizes)) {
            return '';
        }
        $classSuffix=!empty($tag)?"-$tag":'';
        $aSizes=array();
        if(self::is_assoc($sizes)){
            foreach($sizes as $size=>$value) {
                $aSizes[]=sprintf('col-%s%s-%d', $size, $classSuffix, $value);
            }
        }elseif(is_array($sizes)) {
            $refSizes=array('xs', 'sm', 'md', 'lg');
            foreach($sizes as $index=>$value){
                if(empty($value)) {
                    continue;
                }
                $aSizes[]=sprintf('col-%s%s-%d', $refSizes[$index], $classSuffix, $value);
            }
        }elseif(is_numeric($sizes)) {
                $aSizes[]=sprintf('col-xs%s-%d', $classSuffix, $sizes);
        }
        return implode(' ', $aSizes);
    }
    public function setContent($content) {
        $this->_content=$content;
        return $this;
    }
    
    public function addClass($class)
    {
        if(empty($class)) {
            return $this;
        }
        return $this->addHelperAttrib('class', $class);
    }

    public function render($helperTag='div')
    {
        $this->setHelperTag($helperTag);
        $html = '';
        $html.=$this->openHelperTag();
        $html.=$this->_content;
        $html.=$this->closeHelperTag();
        return $html;
    }
    
    public function openHelperTag() {
        $this->addClass($this->_sizes);
        $this->addClass($this->_offsets);
        $this->addClass($this->_pulls);
        $this->addClass($this->_pushes);
        return parent::openHelperTag();
    }
    
    

}
