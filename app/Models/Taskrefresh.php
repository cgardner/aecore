<?php

  namespace App\Models;
  use Illuminate\Database\Eloquent\Model;

  class Taskrefresh extends Model {
    
    protected $table = 'taskrefreshdates';
    protected $fillable = ['user_id', 'date_refresh'];
    
    // relation
    public function user() {
      return $this->belongsTo('App\Models\User');
    }
    
  }