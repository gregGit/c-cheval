<?php

namespace Bootstrap3\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bs3ModalRemote extends AbstractHelper
{

    private $_url;

    private $_modal;
//    public function __invoke($id, $header = null, $body = null, $footer = null, $options = null)

    public function __invoke($id, $header = null)
    {
        $this->_modal=$this->getView()->bs3Modal($id);
        $this->_modal->setBody("Chargement en cours")
                ->setHeader($header)
                ->setOptions(array('attribs'=>array('data-role'=>'modal-aj-form')));
        if (null === $header) {
            return new self;
        }
        $this->_modal->setHeader($header);
        return $this->render();
    }

    public function render() {
        return $this->_modal->render();
    }
    
    public function setJsLoader($jsFile = null)
    {
        if (!empty($jsFile)) {
            $this->view->inlineScript()->appendFile($jsFile);
            return $this;
        }
        $this->setDefaultLoader();
        return $this;
    }

    protected function setDefaultLoader()
    {

        $script = '';
        $script.='jQuery(function() {';
        $script.=sprintf('jQuery("[data-target=\'%s\']").click(function(event) {', $this->_id);
$script.="\n";        
        $script.='event.preventDefault();';
$script.="\n";        
        $script.='event.stopPropagation();';
$script.="\n";        
        $script.='var url=jQuery(this).data("url");';
$script.="\n";        
        $script.=sprintf('var modalElement=jQuery("#%s");', $this->_id);
$script.="\n";        
        $script.='jQuery.get(url, jQuery(this).data())';
$script.="\n";        
$script.="\n";        
        $script.='.done(function ( response, status, xhr ) { ';
$script.="\n";        
        $script.='if(response.content !== undefined) {';
$script.="\n";        
        $script.='jQuery(modalElement,".modal-content").replaceWith(response.content);';
$script.="\n";        
        $script.='}';
$script.="\n";        
$script.="\n";        
$script.="\n";        
$script.="\n";        
$script.="\n";        
        $script.='else if(response.form !== undefined) {';
$script.="\n";        
        $script.='jQuery(".modal-body",modalElement).html(response.form);';
$script.="\n";        
        $script.='}';
$script.="\n";        
        $script.='modalElement.modal("show");';
        $script.='})'; //end done()
        $script.=sprintf('.fail(function ( response, status, xhr ) { ', $this->_url);
        $script.='alert("erreur");';
        $script.='});'; //end fail()
        $script.='});'; //end click()
        $script.='});'; //end 
        

        
        $this->view->inlineScript()->appendScript($script, 'text/javascript', array('noescape' => true));
    }

    public function setUrl($url)
    {
        if (empty($url)) {
            return $this;
        }
        $this->_url = $url;
        return $this;
    }

}
