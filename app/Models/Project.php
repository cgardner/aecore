<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = [
        'company_id',
        'user_id',
        'projectcode',
        'number',
        'name',
        'type',
        'start',
        'finish',
        'value',
        'size',
        'size_unit',
        'description',
        'street',
        'city',
        'state',
        'zip_code',
        'status',
        'submittal_code'
    ];

    public function getSizeUnitAttribute()
    {
        $sizeUnit = $this->attributes['size_unit'];
        if ($sizeUnit == '') {
            return '';
        }

        if ($sizeUnit == 'feet') {
            return 'SF';
        }

        return 'SM';
    }

    /**
     * Relationship with the User model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->hasManyThrough('App\Models\User', 'App\Models\Projectuser', 'user_id', 'id');
    }

    /**
     * Relationship with the Projectuser model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectuser()
    {
      return $this->hasMany('App\Models\Projectuser');
    }

    public function forUser(User $user)
    {
        return \DB::table('projects')
            ->select('projects.*')
            ->leftJoin('projectusers', 'projectusers.project_id', '=', 'projects.id')
            ->where('projectusers.user_id', '=', $user->id)
            ->get();
    }
}
