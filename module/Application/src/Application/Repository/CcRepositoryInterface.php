<?php

namespace Application\Repository;

interface CcRepositoryInterface
{
    public function resolveForeignKey(array &$datas);
    
    public function createEntity();
}
