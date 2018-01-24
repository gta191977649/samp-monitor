<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
use App\User;
use App\SeverStatus;
use Auth;
use DB;

class ServerController extends Controller
{
    //
    public function index()
    {
        $servers = Auth::user()->servers()->get();
        
        return view("ucp.server.index",compact('servers'));
    }
    public function indexApi()
    {
        $servers = server::where('hide',0)->get();
        return $servers;
    }
    
    public function add()
    {
        return view("ucp.server.add");
    }


    public function store(Request $req)
    {
        //判断是否数据已有
        $isexist = Server::where('ip',$req["ip"])->where('port',$req["port"])->get();
        if($isexist->count())  return back()->withErrors(array('message' => '你添加的服务器数据已存在,请勿重复添加服务器数据! 数据贡献者:'.$isexist->first()->user->name));
        
        $server = Auth::user()->servers()->create([
            "hostname" => $req["hostname"],
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

        $isexist = Server::where('ip',$req["ip"])->where('port',$req["port"])->where('id','!=',$id)->get();
        if($isexist->count())  return back()->withErrors(array('message' => '你添加的服务器数据已存在,请勿重复添加服务器数据! 数据贡献者:'.$isexist->first()->user->name));
        //->withErrors(array('message' => '游戏昵称或者密码不正确!'));
        $server->update([
            "hostname" => $req["hostname"],
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

    public function playerRecordDateRange($id)
    {
        $server = DB::table("status")
            ->select(DB::raw("DATE_FORMAT(`created_at`,'%Y-%m-%d') as `date`"))
            ->where("server_id",$id)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
       
        return $server;
    }
    public function playerRecord($id,$date)
    {
        if($date == "NAN")
        {
            $server = Server::find($id);
            return $server->status()->whereDate('created_at', DB::raw('CURDATE()'))->get();
        }

        $server = DB::table("status")
        ->select("*" )
        ->where("server_id",$id)
        ->whereRaw(DB::raw("created_at BETWEEN '$date "."00:00:00' AND '".$date." 23:59:59'"))
        ->get();
       
        return $server;
    }
}
