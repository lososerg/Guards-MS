<?php namespace App;

use Illuminate\Database\Eloquent\Model;


class Cases extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description'];

    public function comments()
    {
        return $this->hasMany('App\Comment', 'case_id', 'id')->where('deleted_at', '=', '0000-00-00 00:00:00');
    }

    public function perpetrators()
    {
        return $this->hasMany('App\Perpetrator', 'case_id', 'id')->where('deleted_at', '=', '0000-00-00 00:00:00');
    }

}

