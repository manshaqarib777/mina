<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'slug', 'parent'];

    public function subcategory()
    {
        return $this->hasMany(Categories::class, 'parent');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Categories::class, 'parent','id');
    }
}
