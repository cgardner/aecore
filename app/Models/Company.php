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

    public function csicodes()
    {
        return $this->hasMany('App\Models\Csicode');
    }
    
    /**
     * Relationship with the Slackintegrations model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function slackintegration()
    {
        return $this->hasMany('App\Models\Slackintegration');
    }
    
}