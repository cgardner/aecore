<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;
  
  class Csicode extends Model {
    
    protected $table = 'csicodes';
    protected $fillable = ['code', 'description', 'status'];
    
  }