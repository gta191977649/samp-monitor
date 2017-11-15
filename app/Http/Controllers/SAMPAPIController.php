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
       
        return "-1";
    }
    public function player($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getOnlinePlayers();
        }

        return "-1";
    }
    public function playerList($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getDetailedPlayers();
        }

        return "-1";
    }
    public function ping($ip,$port)
    {
        $query = new SampQuery($ip,$port);

        if ($query->connect()) {

            return $query->getPing();
        }

        return "-1";
    }
    
}
