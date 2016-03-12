<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CcMovementRepository extends CcAbstractRepository
{

    
    public function exchangeArray($datas)
    {
        $movement=parent::exchangeArray($datas);
        if(isset($datas['elements'])) {
            foreach($datas['elements'] as $dataElement){
                unset($dataElement['movement']);
                 $mvtElem=$this->getEntityManager()->getRepository('\Application\Entity\CcMovementElement')->exchangeArray($dataElement);
                 $mvtElem->setMovement($movement);
                 $movement->getElements()->add($mvtElem);
            }
        }
        return $movement;
    }
    public function createEntity()
    {
        return new \Application\Entity\CcMovement;
    }
    public function resolveForeignKey(array &$datas) {
        if(!empty($datas['reprise'])) {
            $datas['reprise'] = $this->getEntityManager()->getRepository('\Application\Entity\CcReprise')->find($datas['reprise']);
        }else{
            $datas['reprise'] = null;
        }
    }
    
//    public function findLazy($id) {
////        $qb = $this->createQueryBuilder('m')
////                ->join('m.elements', 'e')
////                ->addSelect('e')
////        ;
////
////        $qb->where('m.id =:id')->setParameter('id', $id);
////        $query = $qb->getQuery();
////
////            return $query->getResult();
//              
//        $entity=$this->find($id);
//        if(!$entity) {
//            return $entity;
//        }
//        
//        $e=$entity->getElements();
//        foreach($e as $element) {
//            $entity->addElement($element);
//        }
////        $entity->setElements($entity->getElements());
//        return $entity;
//    }
//    public function getWithAllElements($id=null, $returnObject = false)
//    {
//        $qb = $this->createQueryBuilder('r')
//                ->join('r.movements', 'm')
//                ->addSelect('m')
//                ->join('m.elements', 'e')
//                ->addSelect('e')
//                ->join('r.categorie', 'c')
//                ->addSelect('c')
//        ;
//
//        if(null!== $id) {
//             $qb->where('r.id =:reprise_id')->setParameter('reprise_id', $id);
//        }
//        $query = $qb->getQuery();
//
//        if ($returnObject) {
//            return $query->getResult();
//        } else {
//            return $query->getArrayResult();
//        }
//    }

}
