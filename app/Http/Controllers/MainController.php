<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\SAMP\SampQuery;


class MainController extends Controller
{
    //
    public function index()
    {
        $servers = Server::where("hide" , 0)->paginate(15);
        return view('main',compact('servers'));
    }
    public function gtaun()
    {
        $servers = Server::where("hide" , 0)->paginate(15);
        return view('un',compact('servers'));
    }


    public function update()
    {
        return 'FORBBIDEN!';
        /*
        $servers = Server::get();
        
    
        foreach($servers as $server)
        {
            $query = new SampQuery($server->ip,$server->port);

            if($query->connect()) //如果在线
            {
                $info = $query->getInfo();
                $ping = $query->getPing();
    

                $server->status()->create([
                    "player" => $info["players"],
                    "ping" => $ping,
                    "timeout" => false,
                ]); 
                
                continue;
            }
            else
            {
                $server->status()->create([
                    "player" => 0,
                    "ping" => 0,
                    "timeout" => true,
                ]);
                continue;
                
            }    
        }    
        */
           
    }

} 