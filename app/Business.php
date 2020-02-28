<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'business';
    protected $fillable = [
        'user_id'
    ];
	
	
	
	public function user_detail()
    {
       return $this->hasOne('App\User', 'id', 'user_id');
    }
	
	public function created_detail()
    {
       return $this->hasOne('App\User', 'id', 'created_by');
    }
	
}
