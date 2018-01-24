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
            $query = new SampQuery($server->ip,$server->port);

            if($query->connect()) //如果在线
            {
                $info = $query->getInfo();
                $ping = $query->getPing();
    

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
                continue;
                
            }    
        }  
 
    }
}
