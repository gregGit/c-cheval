<?php

namespace Application\Form;
use Application\Form\FormAjaxProviderInterface;
class FormBuilder
{

    private $sm;
    private $em;

    function __construct($sm)
    {
        $this->sm = $sm;
        ;
    }
    protected function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function get($entityClass)
    {
        if(is_object($entityClass)) {
            $entityClass=  (new \ReflectionClass($entityClass))->getShortName();
        }
        
        $formClass=__NAMESPACE__ . '\\'. $entityClass . 'Form';
        if(!class_exists($formClass)) {
            throw new \Exception("La classe de Formulaire $formClass n'existe pas");
        }
        
        $form=new $formClass($this->getEntityManager());
        
        return $form;
    }
    
    
    
    public function getCreate($entityClass, $action=null){
        $form=$this->get($entityClass);
        if(!empty($action)) {
            $form->setAttribute('action', $action);
        }
        $form->addCreateButton();
        return $form;
    }

    public function getUpdate($entityClass, $action=null){
        $form=$this->get($entityClass);
        if(!empty($action)) {
            $form->setAttribute('action', $action);
        }
        $form->addUpdateButton();
        return $form;
    }


}
