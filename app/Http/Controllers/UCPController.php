<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class UCPController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view("ucp.index",compact('user'));
    }

    public function showAddServer()
    {
        
        return view("ucp.server.add");
    }
}
