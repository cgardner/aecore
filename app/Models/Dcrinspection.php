<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcrinspection extends Model
{
    protected $table = 'dcrinspections';
    protected $fillable = [
                    'dcr_id',
                    'inspection_agency',
                    'inspection_type',
                    'inspection_status',
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