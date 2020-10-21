<?php

namespace App\Interfaces;

interface ServiceInterface
{
    public function validadeOnInsert(array $params);
    public function validadeOnUpdate(int $id, $params);
    public function validadeOnDelete(int $id);
    public function afterSave($entity, array $params);
    public function afterUpdate($entity, array $params);
}
