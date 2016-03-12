<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bs3Alert extends AbstractHelper
{

    const ALTER_SUCCESS='success';
    const ALTER_WARNING='warning';
    const ALTER_DANGER='danger';
    private $_content;
    private $_showCloseBtn = true;
    private $_type;

    public function __invoke($content = '', $showCloseBtn = true)
    {
        $that = new self;
        $that->setContent($content)
                ->setCloseBtn($showCloseBtn)
                ;
        return $that;
    }

    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    public function setCloseBtn($showCloseBtn)
    {
        $this->_showCloseBtn = $showCloseBtn;
        return $this;
    }

    public function render()
    {
        $html = '';
        $html.=$this->openTag();
        if ($this->_showCloseBtn) {
            $html.=$this->dismissButton();
        }
        $html.=$this->_content;
        $html.=$this->closeTag();
        return $html;
    }

    public function dismissButton()
    {
        return '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
    }
    public function warning() {
        $this->_type=self::ALTER_WARNING;
        return $this->render();
    }
    public function success() {
        $this->_type=self::ALTER_SUCCESS;
        return $this->render();
    }
    public function danger() {
        $this->_type=self::ALTER_DANGER;
        return $this->render();
    }
    public function error() {
        $this->_type=self::ALTER_DANGER;
        return $this->render();
    }

    public function openTag()
    {
        $class=array();
        switch ($this->_type) {
            case self::ALTER_DANGER:
                $class[]='alert-danger';
                break;
            case self::ALTER_SUCCESS:
                $class[]='alert-success';
                break;
            case self::ALTER_WARNING:
                $class[]='alert-warning';
                break;
        }
        if($this->_showCloseBtn){
            $class[]='alert-dismissible';
        }
        return sprintf('<div class="alert %s fade in" role="alert">', implode(' ',$class));
    }

    public function closeTag()
    {
        return '</div>';
    }

}
