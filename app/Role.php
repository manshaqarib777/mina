<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =[

        "id","title",
    ];

    public function document()
    {
    	return $this->hasMany('App/Document');
    	
    }

    public function user()
    {
    	return $this->hasMany('App/User');
    }
}
