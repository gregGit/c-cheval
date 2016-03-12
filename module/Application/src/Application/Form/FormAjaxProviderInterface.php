<?php

namespace Application\Form;

interface FormAjaxProviderInterface
{

    public function setAjaxForm();
    public function setMessageContainer($domElement=null);
}
