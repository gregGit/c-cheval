<?php

namespace Application\Form;

use Application\Entity\CcMovementElement;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class BsFormBuilder
{

    private $sm;
    private $em;

    public function get($entity, $bind = false)
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm($entity);
        $form->setEntityManager($this->getEntityManager());

        if(method_exists($form, 'defineHydrators')) {
            $form->defineHydrators();
        } else {
            $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), get_class($entity)));
        }

//        $form->setIdentifierField();
        if ($bind === true) {
            $form->bind($entity);
        }
        return $form;
    }

    function __construct($sm)
    {
        $this->sm = $sm;
        ;
    }

    public function formMovement()
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new \Application\Entity\CcMovement());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Application\Entity\CcMovement'));

        return $form;
    }

    public function newMovement($forDialog = false)
    {
        $form = $this->formMovement();
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Ajouter',
                'id' => 'submitbutton',
            ),
        ));
        return $form;
    }

    protected function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    /*
      public function formReprise()
      {
      $builder = new AnnotationBuilder($this->getEntityManager());
      $form = $builder->createForm(new \Application\Entity\CcReprise());
      $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Application\Entity\CcReprise'));

      $list = $this->getEntityManager()->getRepository('Application\Entity\CcCategorie')->findForSelect();
      $form->get('categorie')->setValueOptions($list)->setOption('value_options', $list);
      return $form;
      }

      public function newReprise()
      {
      $form = $this->formReprise();
      $form->add(array(
      'name' => 'submit',
      'attributes' => array(
      'type' => 'submit',
      'value' => 'Ajouter',
      'id' => 'submitbutton',
      ),
      ));
      return $form;
      }

      public function modifyReprise($elem)
      {
      $form = $this->formReprise();
      $form->add(array('name'=>'id',
      'attributes' => array(
      'type' => 'hidden',
      'value' => $elem->getId()
      )));
      $form->add(array(
      'name' => 'submit',
      'attributes' => array(
      'type' => 'submit',
      'value' => 'Modifier',
      'id' => 'submitbutton',
      ),
      ));

      $form->bind($elem);
      return $form;
      }
     */

    public function formMvtElement()
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm(new CcMovementElement());
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Application\Entity\CcMovementElement'));
        return $form;
    }

    public function newMvtElement($movement, $forDialog = false)
    {
        $form = $this->formMvtElement();
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Ajouter',
                'id' => 'submitbutton',
            ),
        ));
        return $form;
    }

    public function modifyMvtElement($elem)
    {
        $form = $this->formMvtElement();
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Modifier',
                'id' => 'submitbutton',
            ),
        ));

        $form->bind($elem);
        return $form;
    }

    public function modifyMovement($elem)
    {
        $form = $this->formMovement();
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Modifier',
                'id' => 'submitbutton',
            ),
        ));

        $form->bind($elem);
        return $form;
    }

}
