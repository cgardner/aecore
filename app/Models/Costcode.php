<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;
  
  class Costcode extends Model {
    
    protected $table = 'costcodes';
    protected $fillable = ['company_id', 'code', 'description', 'status'];
    
    // relation
    public function company() {
      return $this->belongsTo('App\Models\Company');
    }
    
  }