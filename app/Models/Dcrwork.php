<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcrwork extends Model
{
    protected $table = 'dcrworks';
    protected $fillable = [
                    'dcr_id',
                    'crew_company',
                    'crew_size',
                    'crew_hours',
                    'crew_work',
                    'status' // active, disabled
                ];

    /**
     * Relationship with the Dcr model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcr()
    {
        return $this->belongsTo('App\Models\Dcr');
    }
    
}