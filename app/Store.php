<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'store';
    protected $fillable = [
        'business_id'
    ];
	
	
	
	public function business_detail()
    {
       return $this->hasOne('App\Business', 'id', 'business_id');
    }
	
	public function created_detail()
    {
       return $this->hasOne('App\User', 'id', 'created_by');
    }
	
}
