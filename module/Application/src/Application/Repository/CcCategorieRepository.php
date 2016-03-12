<?php

namespace Application\Repository;

class CcCategorieRepository extends CcAbstractRepository
{

    public function createEntity()
    {
        return new \Application\Entity\CcCategorie;
    }

    public function resolveForeignKey(array &$datas)
    {
        if (!empty($datas['categorie'])) {
            $datas['categorie'] = $this->getEntityManager()->getRepository('\Application\Entity\CcCategorie')->find($datas['categorie']);
        }
    }

    public function findForSelect()
    {
        $qb = $this->createQueryBuilder('c');
        $query = $qb->getQuery();
        $rows = $query->getArrayResult();
        $ret = Array();
        foreach ($rows as $row) {
            $ret[$row['id']] = $row['name'];
        }
        return $ret;
    }

}
