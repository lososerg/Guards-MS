<?php namespace App;

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
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

  public function openCases() 
  {
      return $this->hasMany('Cases', 'owner_id')->whereRaw('status < 3');
  }
  
  public function cases() 
  {
      return $this->hasMany('Cases', 'owner_id');
  }
  
  public function closedCasesLastWeek() 
  {
     $cases = $this->hasMany('App\Cases', 'owner_id')->where('status', '=', 3);
      $cases = $cases->filter(function($case)
                      {
        if ((time() - strtotime($case->updated_at)) <= 60*60*24*7){
          return true;
        }
      });
      /*return $this->hasMany('App\Cases', 'owner_id')->where('status', '=', 3)->count();*/$cases->count();
  }
}
