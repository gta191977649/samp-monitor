<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SAMP\SampQuery;
use App\Server;

class SAMPAPIController extends Controller
{
    //Frontend

    public function frontendQuery()
    {
        return view("ucp.api.query");
    }

    public function info($id){
        
        /*hostname: response.data.hostname,
                        players: response.data.players,
                        maxplayers: response.data.maxplayers,
                        gamemode: response.data.gamemode
                        */
        
        $serv = Server::findOrFail($id);
        
        $out = [
            "hostname" => $serv->hostname,
            "players" => $serv->player(),
            "gamemode" => $serv->gamemode,
            "avgplayer" => $serv->status->count() ? round($serv->thisWeek->avg('player')) : "暂无统计",
            "avgping" => $serv->status->count() ? round($serv->thisWeek->avg('ping')) : "暂无统计",
            "maxplayerrec" => $serv->status->count() ? $serv->status->max('player') : "暂无统计",
            "recordtime" => $serv->status()->select('created_at')->orderBy('player', 'desc')->first()->created_at->format('Y-m-d H:m:s'),
        ];
        return $out;     
    }

    public function liveInfo($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getInfo();
        }
       
        return null;
    }

 

    public function player($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getOnlinePlayers();
        }

        return null;
    }
    public function playerList($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getDetailedPlayers();
        }

        return null;
    }
    public function ping($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getPing();
        }

        return null;
    }

    public function rules($ip,$port)
    {
        $query = new SampQuery($ip,$port);
        if ($query->connect()) {
            return $query->getRules();
        }

        return null;
    }
    //对外开放API
    public function getInfo(Request $req)
    {
        return $req;
        $ip = $req["ip"];
        $port = $req["port"];
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getInfo();
        }
       
        return null;
    }

}
