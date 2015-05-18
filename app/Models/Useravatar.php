<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;
  
  class Useravatar extends Model {
    
    protected $table = 'useravatars';
    protected $fillable = ['user_id', 'file_id_sm', 'file_id_lg'];
    
    // relation
    public function user() {
      return $this->belongsTo('App\Models\User');
    }
    
    public function getUserAvatar($id, $size) {
      // Grab user avatar
      $image = \DB::table('users')
              ->leftjoin('useravatars', 'useravatars.user_id', '=', 'users.id')
              ->leftjoin('s3files', 'useravatars.file_id_'.$size, '=', 's3files.id')
              ->where('users.id', '=', $id)
              ->first();
      if($image->user_id != "") {
        $s3 = \AWS::get('s3');
        return $s3->getObjectUrl($image->file_bucket, $image->file_path . '/' . $image->file_name);
      } else {
        // Defaulting to gravatar
        $hash = md5(strtolower(trim($image->email)));
        return 'http://www.gravatar.com/avatar/' . $hash . '?d=identicon';
      }
    }
  }