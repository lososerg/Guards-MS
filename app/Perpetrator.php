<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Perpetrator extends Model {

	public function penalty() 
  {
    return $this->hasOne('App\Penalty', 'perpetrator_id', 'id');
  }

}
