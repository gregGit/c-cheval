<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CcMovementElementRepository extends CcAbstractRepository
{

    
    public function createEntity()
    {
        return new \Application\Entity\CcMovementElement;
    }
    public function resolveForeignKey(array &$datas) {
        if(!empty($datas['movement'])) {
            $datas['movement'] = $this->getEntityManager()->getRepository('\Application\Entity\CcMovement')->find($datas['movement']);
        }else{
            $datas['movement'] = null;
        }
    }
}
