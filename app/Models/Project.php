<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = [
        'company_id',
        'status',
        'name',
        'number',
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
        'submittal_code',
        'user_id'
    ];

    /**
     * Relationship with the User model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relationship with the Company model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
