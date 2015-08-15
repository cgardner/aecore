<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcrequipment extends Model
{
    protected $table = 'dcrequipments';
    protected $fillable = [
                    'dcr_id',
                    'equipment_type',
                    'equipment_qty',
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