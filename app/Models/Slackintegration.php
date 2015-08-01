<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slackintegration extends Model
{

    protected $table = 'slackintegrations';
    protected $fillable = [
                    'project_id',
                    'company_id',
                    'webhook',
                    'channel',
                    'username',
                    'status' // active, disabled
                ];

    /**
     * Relationship with the Project model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * Relationship with the Company model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\User');
    }
}