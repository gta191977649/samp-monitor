<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Server extends Model
{
    //
    protected $fillable = [
        'id','hostname', 'ip', 'port','gamemode','description','user_id','hide','map','weburl','version','maxplayers','failTimes'
    ];
    protected $appends = array('players','lastrec','timeout','realip');
    
    public function getPlayersAttribute()
    {
        return $this->player();  
    }

    public function getLastrecAttribute(){
        $data = $this->hasMany("App\SeverStatus")->select("created_at")->orderBy('created_at', 'desc')->first();
        if($data)
            return "{$data->created_at}";
        return "无记录";
    }
    public function getTimeoutAttribute() {
        $data = $this->hasMany("App\SeverStatus")->orderBy('created_at', 'desc')->first();
        if($data)
            return $data->timeout;
        return -1;
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
        if($data)
            return $data["player"]."/".$this->maxplayers;
        return "无记录";
    }
 
    //只返回这周的东西
    public function thisWeek()
    {
        return $this->hasMany("App\SeverStatus")->where( DB::raw('WEEK(created_at)'), '=', date('n') );
    }
}
