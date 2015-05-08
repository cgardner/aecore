<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;

  class Taskdate extends Model {
    
    protected $table = 'taskdates';
    protected $fillable = ['task_id', 'date_due', 'date_complete'];
    
    // relation
    public function task() {
      return $this->belongsTo('App\Models\Task');
    }  
  }