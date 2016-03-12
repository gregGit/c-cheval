<?php
namespace Restapi\Controller;


use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

interface RestapiControllerInterface
{
    public function setRepository($repository);
    public function getEntityManager();
    public function setEntityManager($em);

}