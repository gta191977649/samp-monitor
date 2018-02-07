<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
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

    //只返回这周的东西
    public function thisWeek()
    {
        return $this->hasMany("App\SeverStatus")->where( DB::raw('WEEK(created_at)'), '=', date('n') );
    }
}
