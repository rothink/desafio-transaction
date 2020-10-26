<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

abstract class AbstractService implements ServiceInterface
{
    protected $with = [];

    /**
     * @param $data
     * @return mixed
     */
    public function getAll(array $params = [])
    {
        return $this->repository->all($params, $this->with);
    }

    /**
     * @param int $id
     * @param array $with
     * @return mixed
     * @throws \Exception
     */
    public function find(int $id, array $with = [])
    {
        $result = $this->repository->find($id, $with);
        if ($result == null) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }
        return $result;

    }

    /**
     * @param array $data
     * @return array
     */
    public function beforeSave(array $data)
    {
        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $data = $this->beforeSave($data);
        if ($this->validateOnInsert($data) !== false) {
            $entity = $this->repository->create($data);
            $this->afterSave($entity, $data);
            return $entity;
        }
    }

    public function afterSave($entity, array $params)
    {
        return $entity;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function update(int $id, array $data)
    {
        $this->validateOnUpdate($id, $data);
        $entity = $this->find($id);
        $this->afterUpdate($entity, $data);
        return $this->repository->update($entity, $data);
    }

    public function afterUpdate($entity, array $params)
    {

    }

    public function beforeDelete(int $id)
    {
        return $id;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $this->validateOnDelete($id);
        $this->beforeDelete($id);
        $this->repository->delete($id);
        $this->afterDelete($id);
        return $id;
    }

    public function afterDelete($entity)
    {
        return $entity;
    }

    /**
     * @param bool $withGenerateSelectOption
     * @return array
     */
    public function toSelect(bool $withGenerateSelectOption = true)
    {
        if ($withGenerateSelectOption) {
            return generateSelectOption($this->repository->list());
        }
        return $this->repository->list();
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateOnInsert(array $params)
    {

    }

    /**
     * Validação ao atualizar um registro
     * @param $id
     * @param $params
     */
    public function validateOnUpdate(int $id, array $params)
    {

    }

    /**
     * Validação ao deletar um registro
     * @param int $id
     */
    public function validateOnDelete(int $id)
    {
        $result = $this->repository->find($id);
        if ($result == null) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return mixed
     */
    public function getUserAuth()
    {
        return Auth::user();
    }

    /**
     * @param string $url
     * @param string $message
     * @return bool
     */
    public function makeRequestExterna(string $url, string $messageComparation): bool
    {
        $response = Http::get($url);
        return
            $response->status() === Response::HTTP_OK &&
            $response->json()['message'] == $messageComparation;
    }
}
