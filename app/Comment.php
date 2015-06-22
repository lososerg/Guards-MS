<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    public function scopeActive($query)
    {
        return $query->where('deleted_at', '=', '0000-00-00 00:00:00');
    }

}
