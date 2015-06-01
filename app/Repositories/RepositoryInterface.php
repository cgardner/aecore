<?php
namespace App\Repositories;

interface RepositoryInterface
{
    public function create(array $attributes = array());

    public function find($id, array $columns = array('*'));

    public function all(array $columns = array('*'));

    public function destroy($ids);
}