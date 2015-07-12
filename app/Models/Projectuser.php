<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectuser extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INVITED = 'invited';
    const STATUS_DISABLED = 'disabled';

    const ACCESS_ADMIN = 'admin';
    const ACCESS_COLLAB = 'collab';
    const ACCESS_LIMITED = 'limited';

    const ROLE_DEFAULT = 'default';

    protected $table = 'projectusers';
    protected $fillable = [
                    'project_id',
                    'user_id',
                    'access', // admin, collab, limited
                    'role',
                    'status' // active, invited, disabled
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
     * Relationship with the User model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}