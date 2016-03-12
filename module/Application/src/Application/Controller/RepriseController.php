<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\CcReprise;

class RepriseController extends AbstractActionController
{

    /**
     * @var DoctrineORMEntityManager
     */
    protected $em = null;
    private $_sl;

    public function __construct($serviceLocator)
    {
        $this->_sl = $serviceLocator;
        ;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->_sl->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function getRepriseRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\CcReprise');
    }

    public function getMvtElementRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\CcMovementElement');
    }

    public function indexAction()
    {
        $listReprises = $this->getRepriseRepository()->findAll();
        return new ViewModel(array('listReprises' => $listReprises
        ));
    }

    public function ajoutAction()
    {
        
    }

    /**
     * 
     * @param CcReprise $Reprise
     * @return CcRepriseForm
     */
    public function getForm(CcReprise $Reprise)
    {
        if (!empty($Reprise->getId())) {
            $form = $this->_sl->get('Application\Form\FormBuilder')->getUpdate(new CcReprise(), $this->url()->fromRoute('reprise/edit', array('action' => 'create', 'id' => $Reprise->getId())));
        } else {
            $form = $this->_sl->get('Application\Form\FormBuilder')->getCreate(new CcReprise(), $this->url()->fromRoute('reprise/default', array('action' => 'creer')));
        }
        $form->bind($Reprise);
        return $form;
    }

    public function creerAction()
    {
        $Reprise = new \Application\Entity\CcReprise();
        $form = $this->getForm($Reprise);

        $prg = $this->prg($form->getAttribute('action'), true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return array('form' => $form);
        }

        $form->setData($prg);
        if ($form->isValid()) {
            $this->getEntityManager()->persist($Reprise);
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage(sprintf('La reprise %s a été ajoutée', $Reprise->getName()));
            return $this->redirect()->toRoute('reprise/edit', array('id' => $Reprise->getId()));
        } else {
            $this->flashMessenger()->addMessage('Vérifier les inmformations saisies');
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', false);
        if (empty($id)) {
            $this->redirect()->toRoute('reprise');
            return false;
        }
        $Reprise = $this->getRepriseRepository()->find($id);
        if (!$Reprise) {
            $this->redirect()->toRoute('reprise');
            return false;
        }

        $form = $this->getForm($Reprise);
        $form->setAjaxForm()
                ->setMessageContainer('#ajStatus')
                ->setAttribute('action', $this->url()->fromRoute('rest-reprise/rest-full', array('id' => $Reprise->getId())))
                ->setAttribute('method', 'PUT')
;


        $view = new ViewModel();
        $view->setVariable('Reprise', $Reprise);
//        $view->setVariable('addMovementForm', $this->_sl->get('Application\Form\BsFormBuilder')->get(new \Application\Entity\CcMovement()));
        $view->setVariable('editRepriseForm', $form);



        return $view;
    }

    public function updateAction()
    {
        $prg = $this->prg($this->url('reprise/edit', array('id' => $Reprise->getId())), false);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return array('form' => $form);
        }

        $form->setData($prg);
        if ($form->isValid()) {
            $this->getEntityManager()->persist($Reprise);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute('reprise/edit', array('id' => $Reprise->getId()));
        } else {
            $e = $form->getMessages();
        }

        return array('form' => $form);
    }

    public function testAction()
    {

        return array();
    }

}
