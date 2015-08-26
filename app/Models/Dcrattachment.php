<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcrattachment extends Model
{
    protected $table = 'dcrattachments';
    protected $fillable = [
                    'dcr_id',
                    's3file_id',
                    'user_id',
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
    public function s3file()
    {
        return $this->belongsTo('App\Models\s3file');
    }
    
}