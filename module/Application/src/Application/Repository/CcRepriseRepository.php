<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class CcRepriseRepository extends CcAbstractRepository
{
    
    
    public function createEntity()
    {
        return new \Application\Entity\CcReprise;
    }

    public function resolveForeignKey(array &$datas) {
        if(!empty($datas['categorie'])) {
            $datas['categorie'] = $this->getEntityManager()->getRepository('\Application\Entity\CcCategorie')->find($datas['categorie']);
        }else{
            $datas['categorie'] = null;
        }
    }
    public function getWithAllElements($id=null, $returnObject = false)
    {
        $qb = $this->createQueryBuilder('r')
                ->join('r.movements', 'm')
                ->addSelect('m')
                ->join('m.elements', 'e')
                ->addSelect('e')
                ->join('r.categorie', 'c')
                ->addSelect('c')
        ;

        if(null!== $id) {
             $qb->where('r.id =:reprise_id')->setParameter('reprise_id', $id);
        }
        $query = $qb->getQuery();

        if ($returnObject) {
            return $query->getResult();
        } else {
            return $query->getArrayResult();
        }
    }

}
