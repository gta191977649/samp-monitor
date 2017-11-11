<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Server;
class MainController extends Controller
{
    //
    public function index()
    {
        $servers = Server::get();
        return view('main',compact('servers'));
    }
}
