<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;
use AWS;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['usercode', 'name', 'email', 'username', 'password', 'title', 'timezone', 'status', 'signup_step', 'company_id', 'company_user_access', 'company_user_status'];
  // usercode = random string (10) unique identifier used throughout the site to prevent single digit user id entries.
  
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

  // Relations
  public function userphone() {
    return $this->hasOne('App\Models\Userphone');
  }
  public function useravatar() {
    return $this->hasOne('App\Models\Useravatar');
  }
  public function task() {
    return $this->hasMany('App\Models\Task');
  }
  public function tasklist() {
    return $this->hasMany('App\Models\Tasklist');
  }
  public function s3file() {
    return $this->hasMany('App\Models\S3file');
  }
  public function company() {
    return $this->belongsTo('App\Models\Company');
  }
  
  // User functions  
  public function getGravatarAttribute() {
    // Grab user avatar
    $image = Useravatar::where('useravatars.user_id', '=', Auth::user()->id)
            ->leftjoin('s3files', 'useravatars.file_id_lg', '=', 's3files.id')
            ->count();    
    if($image > 0) {
      $s3 = AWS::get('s3');
      return $s3->getObjectUrl($image->file_bucket, $image->file_path . '/' . $image->file_name);
    } else {
      // Defaulting to gravatar
      $hash = md5(strtolower(trim($this->attributes['email'])));
      return 'http://www.gravatar.com/avatar/' . $hash . '?d=identicon';
    }
  }
  
}