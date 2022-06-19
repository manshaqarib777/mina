<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable=[

        "role_id", "title","comentario","create_date", "file_name", "expired_date", "email", "mobile","categoria_id"
    ];


    public $timestamps  = false;
}
