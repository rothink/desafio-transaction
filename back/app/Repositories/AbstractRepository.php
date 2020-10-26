<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param $params
     * @param null $with
     * @return mixed
     */
    public function all($params = null, $with = [])
    {
        return $this->model->with($with)->query($params)->get();
    }

    /**
     * Retorna em forma de lista para selecte
     * @return mixed
     */
    public function list($sortBy = 'name', $pluck = 'name'): array
    {
        return $this->model->all()->sortBy($sortBy)->pluck($pluck, 'id')->all();
    }

    /**
     * @param $params
     * @return Model
     */
    public function create($params): Model
    {
        return $this->model->forceCreate($this->formatParams($params));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * @param int $int
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Usário logado
     * @param $params
     * @return mixed
     */
    public function findByUserAuth(array $params)
    {
        if (isset($params['id_user']) && !empty($params['id_user'])) {
            return $this->findOrFail($params['id_user']);
        }
        return Auth::user()->id;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $model = $this->find($id);
        $model->delete();
    }

    /**
     * @param $entity
     * @param $data
     */
    public function update(Model $entity, $data)
    {
        $entity->forceFill($this->formatParams($data))->save();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function formatParams($params)
    {
        return $params;
    }
}
