<?php

  namespace App\Models;
  use Illuminate\Database\Eloquent\Model;

  class Projectuser extends Model {
    
    protected $table = 'projectusers';
    protected $fillable = ['project_id', 'user_id', 'access', 'role', 'status'];
    
    /**
     * Relationship with the Project model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project() {
      return $this->belongsTo('App\Models\Project');
    }
    
  }