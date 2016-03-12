<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bs3Modal extends Bs3AbstractHelper
{

    protected $_header;
    protected $_body;
    protected $_footer;

    protected $_htmlHeader=false;
    protected $_hideDismiss=false;
    protected $_noFade=false;
    protected $_id;
    protected $_idLabel;
    public function __invoke($id, $header = null, $body = null, $footer = null, $options = null)
    {
        
        $that=new self;
        $that->setId($id);
        $that->setOptions($options);
        $that->setHelperTag('div')
                ->addHelperAttrib('class', 'modal')
                ->addHelperAttrib('tabindex', '-1')
                ->addHelperAttrib('role', 'dialog')
                ->addHelperAttrib('aria-labelledby', $this->_idLabel)
                ;

        if ($header === null && null === $body && null === $footer) {
            return $that;
        }

        $that->setHeader($header)->setBody($body)->setFooter($footer);
        return $that->render();
    }

    public function getId() {
        return $this->_id;
    }
    public function setId($id) {
        if(empty($id)) {
            throw new Exception("Le modal doit avoir un identifiant");
        }
        $this->_id=$id;
        $this->setHelperAttrib('id', $this->_id);

        $this->_idLabel=sprintf('%sLabel', $this->_id);
        return $this;
    }
    public function setHeader($header)
    {
        $this->_header = $header;
        return $this;
    }

    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    public function setFooter($footer)
    {
        $this->_footer = $footer;
        return $this;
    }

    public function render()
    {
        $html = '';
        $html.=$this->openHelperTag();
        $html.=$this->renderHeader();
        $html.=$this->renderBody();
        $html.=$this->renderFooter();
        $html.=$this->closeHelperTag();
        return $html;
    }


    public function renderFooter() {
        $html='';
        $html.=' <div class="modal-footer">';
        $html.=$this->_footer;
        $html.='</div>';
        return $html;
    }
    
    public function renderBody() {
        $html='';
        $html.=' <div class="modal-body">';
        $html.=$this->_body;
        $html.='</div>';
        return $html;
    }

    public function renderHeader() {
        if(null===$this->_header) {
            return '';
        }
        $html='';
        $html.='<div class="modal-header">';
        if($this->_htmlHeader==true) {
            $html.=$this->_header;
        } else {
            $html.=$this->renderDismissButton();
            $html.=$this->renderTitle();
        }
        $html.='</div>';
        
        return $html;
    }
    
    public function renderTitle() {
        return sprintf('<h4 class="modal-title" id="%s">%s</h4>', $this->_idLabel, $this->_header);
    }
    public function renderDismissButton() {
        return '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    }
    
     public function openHelperTag()
    {
        $html = '';
        if($this->_noFade!==true) {
            $this->addHelperAttrib('class', 'fade');
        }
        $html.=parent::openHelperTag();
        $html.='<div class="modal-dialog" role="document">';
        $html.='<div class="modal-content">';
        return $html;
    }
     public function closeHelperTag()
    {
         $html = '';
         $html.='</div>';
         $html.='</div>';
         $html.=parent::closeHelperTag();
         return $html;
     }

}
