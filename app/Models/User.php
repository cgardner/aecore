<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
	protected $fillable = ['name', 'email', 'username', 'password', 'usercode', 'title', 'status', 'signup_step', 'company_id', 'company_user_access', 'company_user_status'];
  // usercode = random string (10) unique identifier used throughout the site to prevent single digit user id entries.
  
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

  public function getGravatarAttribute() {    
    // Defaulting to gravatar until storage is finalized
    $hash = md5(strtolower(trim($this->attributes['email'])));
    return 'http://www.gravatar.com/avatar/' . $hash . '?d=identicon';
  }
  
}