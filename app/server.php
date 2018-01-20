<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    //
    protected $fillable = [
        'id','hostname', 'ip', 'port','gamemode','description','user_id','hide'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->hasMany("App\SeverStatus");
    }
}
