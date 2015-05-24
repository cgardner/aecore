<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;

  class Task extends Model {
    
    protected $table = 'tasks';
    protected $fillable = ['user_id', 'assigned_by', 'tasklist_id', 'taskcode', 'task', 'status', 'priority'];
    
    // relation
    public function user() {
      return $this->belongsTo('App\Models\User');
    }
    public function tasklist() {
      return $this->belongsTo('App\Models\Tasklist');
    }
    public function taskdate() {
      return $this->hasMany('App\Models\Taskdate');
    }
    public function taskfollower() {
      return $this->hasMany('App\Models\Taskfollower');
    }
    public function taskfeed() {
      return $this->hasMany('App\Models\Taskfeed');
    }
    
  }