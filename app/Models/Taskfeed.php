<?php

  namespace App\Models;
  use Illuminate\Database\Eloquent\Model;
  
  class Taskfeed extends Model {
    
    protected $table = 'taskfeeds';
    protected $fillable = ['task_id', 'user_id', 'type', 'comment', 'status'];
    
    // relation
    public function task() {
      return $this->belongsTo('App\Models\Task');
    }
    
  }