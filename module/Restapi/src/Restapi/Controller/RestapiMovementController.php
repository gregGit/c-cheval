<?php

namespace Restapi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class RestapiMovementController extends AbstractRestapiController
{

    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\CcMovement');
    }

    public function getList()
    {
//                $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//        $queryBuilder->select('r')
//                ->from('Application\Entity\CcReprise', 'r')
//                ->join('Application\Entity\CcMovement', 'm', 'WITH', 'r.id=m.reprise');
//        $results = $queryBuilder->getQuery()
//                ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
//        $result = new JsonModel($results);
//                return $result;
//
        //        


        $list = $this->getEntityManager()->getRepository('Application\Entity\CcReprise')->getWithAllElements();

//        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//        $queryBuilder->select('t')
//                ->from('Application\Entity\CcCategorie', 't');
//        $results = $queryBuilder->getQuery()
//                ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
//        $result = new JsonModel($results);
//                return $result;

        $jlist = new JsonModel($list);




        $result = new JsonModel($list);
        return $result;

//        $response = $this->getResponseWithHeader()
//                ->setContent(__METHOD__ . ' get the list of data');
//        return $response;
//
        //
        //        return array('data' => $data);
    }

    public function get($id)
    {
        $rerprise = $this->getEntityManager()->getRepository('Application\Entity\CcReprise')->getWithAllElements($id);

        $result = new JsonModel($rerprise);
        return $result;
    }

    public function create($data)
    {
        $a = $adata;
    }

    public function update($id, $data)
    {
        $a = $adata;
# code...
    }

    /**
     * F
     */
    public function addElementAction()
    {
        
    }

    
    
    

    
    
    public function submitAction()
    {
        $reprise_id = $this->params()->fromRoute('reprise_id');
        $posts = $this->params()->fromPost();
        if (empty($posts['reprise'])) {
            $posts['reprise'] = $reprise_id;
        }

        if ($posts['reprise'] !== $reprise_id) {
            throw new \Exception('Incohérence dans les ID');
        }

        $form2 = $this->getSrvLocator()->get('Application\Form\BsFormBuilder')->newMovement();
        $form = $this->getForm(new \Application\Entity\CcMovement());

        $form->setData($posts);
        if ($form->isValid()) {
            $movement = $this->getRepository()->exchangeArray($posts);
            $em = $this->getEntityManager();
            $em->persist($movement);
            $em->flush();

            $helper = $this->getViewHelper('repriseMovementRow');
            return new JsonModel(array(
                'success'=>true,
                'rowDatas'=>$this->getRepository()->serialize($movement),
                'rowHtml'=>$helper($movement)->render()
                    )
            );
        }else {
            return new JsonModel(array(
                'success'=>false,
                'messages'=>   $form->getMessages()
            ));
        }
       
    }

}
