<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bs3Button extends AbstractHelper
{

    const BTN_DEFAULT='default';
    const BTN_PRIMARY='primary';
    const BTN_SUCCESS='success';
    const BTN_INFO='info';
    const BTN_WARNING='warning';
    const BTN_DANGER='danger';
    const BTN_LINK='link';

    const BTN_LARGE='lg';
    const BTN_SMALL='sm';
    const BTN_XS='xs';
    
    private $_content;
    private $_active=true;
    private $_disabled=false;
    private $_size;
    private $_type;
    private $_attribs;
    public function __invoke($content = '', $type=null, $size=null, $disabled=null, $active=null, array $attribs=null)
    {
        $that = new self;
        
        $that->setContent($content)
                ->setType($type)
                ->setSize($size)
                ->setDisabled($disabled)
                ->setActive($active)
                ->setAttribs($attribs)
                ;
                
        if(!empty($content)) {
            return $that->render();
        }
        return $that;
    }

    public function setAttribs(array $attribs=null) {
        $this->_attribs=$attribs;
        return $this;
    }
    public function setActive($active=true) {
        $this->_active=$active;
        return $this;
    }
    public function setSize($size='') {
        $this->_size=$size;
        return $this;
    }
    public function setType($type=self::BTN_DEFAULT) {
        $this->_type=$type;
        return $this;
    }
    public function setDisabled($disabled=false) {
        $this->_disabled=$disabled;
        return $this;
    }
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }
    public function render()
    {
        $html = '';
        $html.=$this->openTag();
        $html.=$this->_content;
        $html.=$this->closeTag();
        return $html;
    }
    
    public function getClass() {
        $class=array();
        $class[]='btn';
        $class[]='btn-'.$this->_type;
        if($this->_active) {
            $class[]='active';
        }
        $class[]='btn-'.$this->_size;
        
        return implode(' ', $class);
    }

    public function getAttrib() {
        if(!is_array($this->_attribs)) {
            return '';
        }
        $att=array();
        foreach($this->_attribs as $name=>$value) {
            $att[]=sprintf('%s="%s"',$name, htmlentities($value, ENT_COMPAT));
        }
        if($this->_disabled) {
            $att[]='disabled="disabled"';
        }
        return implode(' ', $att);
    }
    public function openTag()
    {
        return sprintf('<button type="button" class="%s" %s>',$this->getClass(), $this->getAttrib());
    }

    public function closeTag()
    {
        return '</button>';
    }

    
    public function normal($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_DEFAULT);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function primary($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_PRIMARY);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function success($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_SUCCESS);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function info($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_INFO);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function warning($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_WARNING);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function danger($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_DANGER);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
    public function link($content=null) {
        if(null!==$content) {
            $this->setContent($content);
        }
        $this->setType(self::BTN_LINK);
        
        if(!empty($this->_content)) {
            return $this->render();
        }
        
        return $this;
    }
}
