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
    protected $appends = array('players','lastrec','timeout','realip');
    
    public function getPlayersAttribute()
    {
        return $this->player();  
    }

    public function getLastrecAttribute(){
        $data = $this->hasMany("App\SeverStatus")->select("created_at")->orderBy('created_at', 'desc')->first();
        return "{$data->created_at}";
    }
    public function getTimeoutAttribute() {
        $data = $this->hasMany("App\SeverStatus")->orderBy('created_at', 'desc')->first();
        return $data->timeout;
    }
    public function getRealipAttribute(){
        return gethostbyname($this->ip);
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->hasMany("App\SeverStatus");
    }

    public function player() {
        $data = $this->hasMany("App\SeverStatus")->orderBy('created_at', 'desc')->first();
        return $data["player"];
    }
 
    //只返回这周的东西
    public function thisWeek()
    {
        return $this->hasMany("App\SeverStatus")->where( DB::raw('WEEK(created_at)'), '=', date('n') );
    }
}
