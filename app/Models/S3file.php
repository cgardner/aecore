<?php

  namespace App\Models;
  use Illuminate\Database\Eloquent\Model;

  class S3file extends Model {
    
    protected $table = 's3files';
    protected $fillable = ['user_id', 'file_bucket', 'file_path', 'file_name', 'file_size'];
    
    // relation
    public function user() {
      return $this->belongsTo('App\Models\User');
    }
  
    public function dcrattachment()
    {        
        return $this->belongsTo('App\Models\Dcrattachment');
    }
 
}