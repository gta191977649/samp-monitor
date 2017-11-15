<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SAMP\SampQuery;

class SAMPAPIController extends Controller
{
    //Frontend

    public function frontendQuery()
    {
        return view("ucp.api.query");
    }

    //API

    public function info($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getInfo();
        }
    }
    public function player($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getOnlinePlayers();
        }
    }
    public function playerList($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getDetailedPlayers();
        }
    }
    public function ping($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getPing();
        }
    }
    
}
