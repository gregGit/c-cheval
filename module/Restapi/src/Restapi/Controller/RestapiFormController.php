<?php

namespace Restapi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestapiFormController extends AbstractRestapiController
{

    const CONTENT_TYPE_JSON = 'json';

    
    public function getRepository()
    {
        if(!empty($this->_repository)) {
            return $this->_repository;
        }
        
        $repos=$this->params()->fromRoute('repository', false);
        
        $this->_repository=$this->getEntityManager()->getRepository($repos);
        return $this->_repository;
        
    }
    
    
    public function isModalRequest() {
        return $this->params()->fromQuery('toggle', false)==='modal';
    }
    public function get($id)
    {
        
        $entity=$this->getEntityFromParams($id);        
        if ($entity == false) {
            return new JsonModel(array(
                'success' => false,
                'messages' => "L'élément n'existe pas"
            ));
        }
        
        $form=$this->getForm($entity, true);        
//                $form->get('elements')->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager(),'\Application\Entity\CcElements'));

                
//        $company=$this->getRepository()->find($id);
////        $company = new \Application\Entity\Company();
//
//        $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($this->getEntityManager());
//        $form = $builder->createForm($company);
//        
//        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager(),'Application\Entity\CcMovement'));
//        $e=$form->get('elements');
//        $e=$form->get('elements')->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEntityManager(),'Application\Entity\CcMovementElement'));
//        $form->bind($company); 
        
        $form_layout=null;
        if($this->isModalRequest()) {
            if($form instanceof \Application\Form\ModalFormInterface) {
                $form->setModal();
                $form_layout=  \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_HORIZONTAL;
            }
            
        }
        $helper = $this->getViewHelper('form');

            return new JsonModel(array(
                'success' => true,
                'form' => $helper($form->prepare(), $form_layout)
            ));

        
    }

    public function create($data)
    {
        $this->response->setStatusCode(405);
        return [
            'content' => 'Method Not Allowed'
        ];
    }

    public function update($id, $data)
    {
        $this->response->setStatusCode(405);
        return [
            'content' => 'Method Not Allowed'
        ];
    }

    public function delete($id)
    {
        $this->response->setStatusCode(405);
        return [
            'content' => 'Method Not Allowed'
        ];
    }

}
