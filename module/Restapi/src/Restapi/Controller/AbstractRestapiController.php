<?php

namespace Restapi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

Abstract class AbstractRestapiController extends AbstractRestfulController implements RestapiControllerInterface
{

    const CONTENT_TYPE_JSON = 'json';

    /**
     * @var DoctrineORMEntityManager
     */
    protected $em = null;
    protected $_sl;
    protected $_repository;

    public function setRepository($repository)
    {
        $this->_repository = $repository;
    }

    public function getRepository()
    {
        return $this->_repository;
    }

    public function setSrvLocator($sl)
    {
        $this->_sl = $sl;
    }

    public function getSrvLocator()
    {
        return $this->_sl;
    }

    public function getViewHelperManager()
    {
        return $this->getSrvLocator()->get('ViewHelperManager');
    }

    public function getViewHelper($name)
    {
        return $this->getViewHelperManager()->get($name);
    }

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function getResponseWithHeader()
    {
        $response = $this->getResponse();
        $response->getHeaders()
                //make can accessed by *   
                ->addHeaderLine('Access-Control-Allow-Origin', '*')
                //set allow methods
                ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET')
                ->addHeaderLine('Access-Control-Allow-Headers', "Content-Type, Accept");
        return $response;
    }

    public function getFormBuilder()
    {
        return $this->_sl->get('Application\Form\BsFormBuilder');
    }

    public function getForm($name, $bind = false)
    {
        return $this->getFormBuilder()->get($name, $bind);
    }

    public function getEntityFromParams($id = null, $canCreate = false)
    {
        $Entity = $this->valideEntityIdByUuid($id);
        if ($Entity == false && $canCreate) {
            $Entity = $this->getRepository()->createEntity();
        }
        return $Entity;
    }

    /**
     * Recherche l'uuid dans la route
     * 
     * @return String|false uuid ou false si non trouvé
     */
    protected function getUuid()
    {
        $uuid = $this->params()->fromRoute('uuid', false);
        return $uuid;
    }

    /**
     * Validation d'une entité
     * 
     * Retrouve et valide une entité en fonction de son Id et de son UUID
     * L'entité est recherchée par sa clé, si elle est trouvée, l'uuid est vérifié
     * 
     * @param int $id Identifiant de l'entité
     * @param string $uuid uuid de l'entité. Si le paramètre n'est pas spécifié il sera cherché dans la route
     * @return boolean|DoctrineEntity L'objet Doctrine de l'entité si elle est trouvée, false si l'identifiant n'a pas été trouvée
     * @throws \Exception Une exception est levée si id ne correspond pas à l'uuid
     */
    protected function valideEntityIdByUuid($id, $uuid = null)
    {
        if (!empty($id)) {
            $repos = $this->getRepository();
            $Entity = $this->getRepository()->find($id);
            if (!$Entity) {
                return false;
            }
            if (null === $uuid) {
                $uuid = $this->getUuid();
            }
            if ($uuid != $Entity->getUuid()) {
                throw new \Exception('Incohérence dans les ID ' . get_class($Entity) . '/' . $id . '/' . $uuid);
                return false;
            }
            return $Entity;
        } else {
            return false;
        }
    }


    public function doneFormSubmitRespone(array $responseParams=null) {
        if(null===$responseParams) {
            $responseParams=array();
        }
        $responseParams['success']=true;
         return new JsonModel($responseParams);
    }
    
    
    
    protected function getFieldNameFromTree(array $fieldTree) {
        if(count($fieldTree)==1) {
            return $fieldTree[0];
        } else{
            return $fieldTree[0].'['.implode('][', array_slice($fieldTree, 1)).']';
        }
    }
    protected function parseFormError(array $errors, &$fieldTree=array())  {
        $parsedErrors=array();
        foreach($errors as $key=>$value) {
            if(!is_array($value)) {
                $fieldName=$this->getFieldNameFromTree($fieldTree);
                unset($fieldTree[count($fieldTree)-1]);
                $parsedErrors[$fieldName]=$errors;
            } else {
                array_push($fieldTree, $key);
               $parsedErrors=  array_merge($parsedErrors, $this->parseFormError($value, $fieldTree));
            }   
        }
        return $parsedErrors;
    }
    public function failFormSubmitRespone($errors) {
        $errors=$this->parseFormerror($errors);
        $this->response->setStatusCode(400);
         return new JsonModel(array(
            'content' => 'Erreur',
            'xErrors'=>$errors
        ));
    }

    public function delete($id)
    {
        $entity = $this->getEntityFromParams($id);
        if ($entity == false) {
            return new JsonModel(array(
                'success' => false,
                'messages' => "L'élément n'existe pas"
            ));
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        return new JsonModel(array(
            'success' => true
        ));
    }

    
    public function badRequestResponse() {
        
        $this->response->setStatusCode(400);

        return [
            'content' => 'Method Not Allowed'
        ];
    }
}
