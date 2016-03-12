<?php

namespace Application\Form;

use Zend\Form\Form;

interface CcFormInterface
{
        

    /**
     * Définit les tailles des colonnes pour les formulaires horizontaux /inline
     * $sizes est un tableau :
     * 'element'=>array(
     *              "column-size" => "xs-1",
                    "label_attributes" => array("class" => "col-sm-1"),
     * ....
     * );
     * @param array $sizes
     */
    public function setBsHorizontalSizes(array $elementsSizes=null);
    
    
    public function forUpdate();
    
    public function forInsert();
    
    public function setEntityManager($em);
    public function getEntityManager();
    
    public function setIdentifierField();
    
}
