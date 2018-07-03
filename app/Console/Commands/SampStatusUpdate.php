<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SAMP\SampQuery;
use App\Server;

class SampStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samp:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $servers = Server::get();
        foreach($servers as $server)
        {
            if($server->failTimes < 48)
            {
                
                $this->output->write('Process server  = '.$server->hostname."\n", false);

                $query = new SampQuery($server->ip,$server->port);

                if($query->connect()) //如果在线
                {
                    $info = $query->getInfo();
                    $rule = $query->getRules();
                    $ping = $query->getPing();
                    
                    
                    $server->update([
                        "hostname" => $server->hostname == $info["hostname"] || empty($info["hostname"]) ? $server->hostname : $info["hostname"],
                        "gamemode" => $server->gamemode == $info["gamemode"] || empty($info["gamemode"]) ? $server->gamemode : $info["gamemode"],
                        "map" => $server->map == $rule["mapname"] || empty($rule["mapname"]) ? $server->map : $rule["mapname"],
                        "version" => $server->version == $rule["version"] || empty($rule["version"]) ? $server->version : $rule["version"],
                        "weburl" => $server->weburl == $rule["weburl"] || empty($rule["weburl"]) ? $server->weburl : $rule["weburl"],
                        "maxplayers" => $server->maxplayers == $info["maxplayers"] || $info["maxplayers"] == '' ? $server->maxplayers : $info["maxplayers"],
                        "failTimes" => 0,
                    ]);

                    $server->status()->create([
                        "player" => $info["players"] ? $info["players"] : 0 ,
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
                    $server->update([
                        "failTimes" => $server->failTimes+1
                    ]);
                    continue;
                    
                }    
            }
        }  
 
    }
}
