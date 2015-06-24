<?php
namespace App\Repositories;

use App\Models\User;
use DB;

class UserRepository extends AbstractRepository
{
    protected $model;

    const STATUS_ACTIVE = 'active';

    function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByUserCode($userCode)
    {
        return $this->model
            ->where('usercode', '=', $userCode)
            ->first();
    }
}