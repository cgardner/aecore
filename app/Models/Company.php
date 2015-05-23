<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'companys';
    protected $fillable = ['companycode', 'name', 'type', 'labor', 'account', 'status'];

    // relation
    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function companylocation()
    {
        return $this->hasOne('App\Models\Companylocation');
    }

    public function companyavatar()
    {
        return $this->hasOne('App\Models\Companyavatar');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}