<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rfi
 * @package App\Models
 */
class Rfi extends Model
{
    const PRIORITY_HIGH = 'HIGH';
    const PRIORITY_MEDIUM = 'MEDIUM';
    const PRIORITY_LOW = 'LOW';

    const COST_IMPACT_YES = 'YES';
    const COST_IMPACT_NO = 'NO';
    const COST_IMPACT_TBD = 'TBD';

    const SCHEDULE_IMPACT_YES = 'YES';
    const SCHEDULE_IMPACT_NO = 'NO';
    const SCHEDULE_IMPACT_TBD = 'TBD';

    protected $table = 'rfis';

    protected $fillable = [
        'project_id',
        'assigned_user_id',
        'due_date',
        'priority',
        'cost_impact',
        'cost_impact_amount',
        'schedule_impact',
        'schedule_impact_days',
        'references',
        'origin',
        'question',
        'draft'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Model\Project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Model\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\Model\User', 'updated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo()
    {
        return $this->belongsTo('App\Model\User', 'assigned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function files()
    {
        return $this->hasManyThrough('\App\Model\S3File', '\App\Model\RfiFile', 'rfi_id', 'file_id');
    }
}