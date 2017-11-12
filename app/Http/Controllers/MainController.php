<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
class MainController extends Controller
{
    //
    public function index()
    {
        $servers = Server::where("hide" , 0)->get();
        return view('main',compact('servers'));
    }
    public function gtaun()
    {
        $servers = Server::get();
        return view('un',compact('servers'));
    }

}