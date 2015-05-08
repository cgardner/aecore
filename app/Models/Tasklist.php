<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;

  class Tasklist extends Model {
    
    protected $table = 'tasklists';
    protected $fillable = ['user_id', 'listcode', 'list', 'status'];
    
    // relation
    public function user() {
      return $this->belongsTo('App\Models\User');
    }
    public function task() {
      return $this->hasMany('App\Models\Task');
    }
  }