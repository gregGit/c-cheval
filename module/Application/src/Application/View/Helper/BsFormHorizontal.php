<?php

namespace Application\View\Helper;


use Application\Form\FormBsHorizontalProviderInterface;

class BsFormHorizontal extends \Zend\View\Helper\AbstractHelper
{
    public function __invoke(FormBsHorizontalProviderInterface $form)            
    {
        return $this->getView()->form($form->setHorizontalParams(), \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_HORIZONTAL);
    }

  
}
