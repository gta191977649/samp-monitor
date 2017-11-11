<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SAMP\SampQuery;

class SAMPAPIController extends Controller
{
    //
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
    
    
}
