<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UCPController extends Controller
{
    //
    public function index()
    {
        return view("ucp.index");
    }

    public function showAddServer()
    {
        return view("ucp.server.add");
    }
}
