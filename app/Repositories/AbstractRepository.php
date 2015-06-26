<?php
namespace App\Repositories;

use App\Repositories\Exception\MethodNotFoundException;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function create(array $attributes = array())
    {
        return $this->model
            ->create($attributes);
    }

    public function find($id, array $columns = array('*'))
    {
        return $this->model
            ->newQuery()
            ->find($id, $columns);
    }

    public function all(array $columns = array('*'))
    {
        return $this->model
            ->newQuery()
            ->get($columns);
    }

    public function destroy($ids)
    {
        $count = 0;

        $ids = is_array($ids) ? $ids : func_get_args();

        $key = $this->model
            ->getKeyName();

        $models = $this->model
            ->newQuery()
            ->getQuery()
            ->whereIn($key, $ids)
            ->get();

        foreach ($models as $model) {
            if ($model->delete()) {
                $count++;
            }
        }

        return $count;
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this->model, $name)) {
            throw new MethodNotFoundException(sprintf('%s is not a valid method', $name));
        }

        return call_user_func_array([$this->model, $name], $arguments);
    }
}