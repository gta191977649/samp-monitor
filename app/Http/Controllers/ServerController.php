<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use Auth;

class ServerController extends Controller
{
    //
    public function index()
    {
        $servers = Auth::user()->servers()->get();
        
        return view("ucp.server.index",compact('servers'));
    }
    
    public function add()
    {
        return view("ucp.server.add");
    }


    public function store(Request $req)
    {
        
        $server = Auth::user()->servers()->create([
            "name" => $req["name"],
            "ip" => $req["ip"],
            "port" => $req["port"],
            "gamemode" => $req["gamemode"],
            "description" => $req["description"],
            "hide" => $req["hide"],
        ]);
        //$server->store();
        return $this->index();
    }

    public function update(Request $req,$id)
    {   
        
        $server = Auth::user()->servers()->find($id);
        if(!$server) return $this->edit($id)->withErrors(array('message' => '数据ID不正确,无法编辑!'));

        //->withErrors(array('message' => '游戏昵称或者密码不正确!'));
        $server->update([
            "name" => $req["name"],
            "ip" => $req["ip"],
            "port" => $req["port"],
            "gamemode" => $req["gamemode"],
            "description" => $req["description"],
            "hide" => $req["hide"],
        ]);
        //$server->store();
        return redirect()->route("ucp.server.index");
    }

    
    public function del($id)
    {
        $server = Auth::user()->servers()->find($id);
        $server->delete();

        return redirect()->route("ucp.server.index");
    }
    public function edit($id)
    {
        $server = Auth::user()->servers()->find($id);
    
        return view("ucp.server.edit",compact("server"));
    }
    
    public function detail($id)
    {
        $server = Auth::user()->servers()->find($id);
        
        return view("ucp.server.detail",compact("server"));
    }


    public function fontedDetail($id)
    {
        $server =Server::find($id);
        
        return view("ucp.server.detail",compact("server"));
    }
}
