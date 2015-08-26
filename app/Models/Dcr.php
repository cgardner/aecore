<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcr extends Model
{
    protected $table = 'dcrs';
    protected $fillable = [
                    'project_id',
                    'company_id',
                    'date',
                    'weather',
                    'temperature',
                    'temperature_type',
                    'comments',
                    'correspondence',
                    'issues',
                    'safety',
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
     * Relationship with the Dcrwork model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcrwork()
    {
        return $this->hasMany('App\Models\Dcrwork');
    }

    /**
     * Relationship with the Dcrequipment model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcrequipment()
    {
        return $this->hasMany('App\Models\Dcrequipment');
    }

    /**
     * Relationship with the Dcrinspection model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcrinspection()
    {
        return $this->hasMany('App\Models\Dcrinspection');
    }

    /**
     * Relationship with the Dcrattachment model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    
    public function s3files()
    {
        return $this->hasManyThrough('App\Models\S3file', 'App\Models\Dcrattachment', 'file_id', 'id');
    }
    public function dcrattachment()
    {        
        return $this->hasMany('App\Models\Dcrattachment');
    } 
    
   
}