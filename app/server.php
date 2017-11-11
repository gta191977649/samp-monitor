<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class server extends Model
{
    //
    protected $fillable = [
        'name', 'ip', 'port',
    ];
}
