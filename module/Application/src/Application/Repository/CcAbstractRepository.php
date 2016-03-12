<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

Abstract class CcAbstractRepository extends EntityRepository implements CcRepositoryInterface
{

    public function serialize($entity) {
     
        $em= $this->getEntityManager();
        $className = get_class($entity);

        $uow = $em->getUnitOfWork();
        $entityPersister = $uow->getEntityPersister($className);
        $classMetadata = $entityPersister->getClassMetadata();

        $datas = array();
        foreach ($uow->getOriginalEntityData($entity) as $field => $value) {
            if (isset($classMetadata->associationMappings[$field])) {
                $assoc = $classMetadata->associationMappings[$field];

                // Only owning side of x-1 associations can have a FK column.
                if ( ! $assoc['isOwningSide'] || ! ($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
                    continue;
                }

                if ($value !== null) {
                    $newValId = $uow->getEntityIdentifier($value);
                }

                $targetClass = $em->getClassMetadata($assoc['targetEntity']);
                $owningTable = $entityPersister->getOwningTable($field);

                foreach ($assoc['joinColumns'] as $joinColumn) {
                    $sourceColumn = $joinColumn['name'];
                    $targetColumn = $joinColumn['referencedColumnName'];

                    if ($value === null) {
                        $datas[$sourceColumn] = null;
                    } else if ($targetClass->containsForeignIdentifier) {
                        $datas[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
                    } else {
                        $datas[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
                    }
                }
            } elseif (isset($classMetadata->columnNames[$field])) {
                $columnName = $classMetadata->columnNames[$field];
                $datas[$columnName] = $value;
            }
        }

        return $datas;
    
       
        
    }
    public function exchangeArray($datas)
    {
        $entity = false;
        if (isset($datas['id'])) {
            $entity = $this->find($datas['id']);
        }
        if (!$entity) {
            $entity =$this->createEntity();
        }
        $em = $this->getEntityManager();
        $this->resolveForeignKey($datas);

        foreach ($datas as $field => $value) {
            $method = "set" . ucfirst($field);
            if (method_exists(get_class($entity), $method)) {
                $entity->$method($value);
            }
        }
        
        return $entity;
    }
    public static function decamelize($word)
    {
        return preg_replace(
                '/(^|[a-z])([A-Z])/e', 'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")', $word
        );
    }

    public static function camelize($word)
    {
        
        return preg_replace_callback(
    '/(^|_)([a-z])/',   function($m) { return strtoupper($m[2]); },
    $word);
//        return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $word);
    }

}
