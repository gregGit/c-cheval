<?php

namespace Restapi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\CcReprise;

class RestapiRepriseController extends AbstractRestapiController
{

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
        # code...
    }

    public function update($id, $data)
    {
        if(!isset($data['reprise'])) {
            return $this->badRequestResponse();
        }
        $Reprise=$this->valideEntityIdByUuid($id, $data['reprise']['uuid']);
        $form = $this->_sl->get('Application\Form\FormBuilder')->get(new CcReprise());
        $form->bind($Reprise);
        
        $form->setData($data);
        if ($form->isValid()) {
            $this->getEntityManager()->persist($Reprise);
            $this->getEntityManager()->flush();
            return $this->doneFormSubmitRespone();
        } else {
            return $this->failFormSubmitRespone($form->getMessages());
        }
    }

    public function delete($id)
    {
        $a = $id;
    }


    /**
     * F
     */
    public function addElementAction()
    {
        
    }

    public function deleteAction()
    {
        $Reprise = $this->getRepriseFromParams();
        if ($Reprise == false) {
            return new JsonModel(array(
                'success' => false,
                'messages' => "La reprise n'existe pas"
            ));
        }

        $em = $this->getEntityManager();
        $em->remove($Reprise);
        $em->flush();

        return new JsonModel(array(
            'success' => true
        ));
    }

    public function getRepriseFromParams($canCreate = false)
    {
        $reprise_id = $this->params()->fromRoute('reprise_id');
        $posts = $this->params()->fromPost();
        if (!empty($posts['rec_key'])) {
            if ($posts['rec_key'] != $reprise_id) {
                throw new \Exception('Incohérence dans les ID');
                return false;
            }
            $Reprise = $this->getRepository()->find($reprise_id);
        } else {
            if ($canCreate) {
                $Reprise = $this->getRepository()->createEntity();
            } else {
                $Reprise = false;
            }
        }
        return $Reprise;
    }

    public function submitAction()
    {
        $Reprise = $this->getRepriseFromParams(true);
        $posts = $this->params()->fromPost();

        $form = $this->getForm($Reprise);
        $form->setData($posts);
        if ($form->isValid()) {
            $Reprise = $this->getRepository()->exchangeArray($posts);
            $em = $this->getEntityManager();
            $em->persist($Reprise);
            $em->flush();

            $helper = $this->getViewHelper('bs3Alert');
            return new JsonModel(array(
                'success' => true,
                'rowDatas' => $this->getRepository()->serialize($Reprise),
                'rowHtml' => $helper('Modification enregistrée')->success()
                    )
            );
        } else {
            return new JsonModel(array(
                'success' => false,
                'messages' => $form->getMessages()
            ));
        }
    }

}
