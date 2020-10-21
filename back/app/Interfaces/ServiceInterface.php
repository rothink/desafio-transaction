<?php

namespace App\Interfaces;

abstract class ServiceInterface
{
    abstract public function validadeOnInsert(array $params);
    abstract public function validadeOnUpdate(int $id, $params);
    abstract public function validadeOnDelete(int $id);
    abstract public function afterSave($entity, array $params);
    abstract public function afterUpdate($entity, array $params);
}
