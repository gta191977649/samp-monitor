<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeverStatus extends Model
{
    //
    protected $table = 'status';

    protected $fillable = [
        "id","server_id","player","ping","timeout"
    ];

    public function server()
    {
        return $this->belongTo("App\Server");
    }

}
