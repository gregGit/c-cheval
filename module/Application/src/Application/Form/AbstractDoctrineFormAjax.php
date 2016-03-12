<?php

namespace Application\Form;

class AbstractDoctrineFormAjax extends AbstractDoctrineForm implements FormAjaxProviderInterface
{
   public function setMessageContainer($domElement = null)
    {
        $this->setAttribute('data-info-container', $domElement);
        return $this;
    }

    public function setAjaxForm()
    {
        $this->setAttribute('class', 'ajax-submit');
        return $this;
    }
}
