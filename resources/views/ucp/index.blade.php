@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-sm-9">
        <h1>概览 - {{$user->name}}</h1>
        <hr/>
        <div class="col-sm-4 text-center">
            <a href="{{route('ucp.server.index')}}">
                <i class="fa fa-server text-primary" style="font-size: 70px;"></i><br/>
                <h1>{{$user->servers->count()}}</h1>
            </a>
           
           
        </div>
        <div class="col-sm-4 text-center">...</div>
        <div class="col-sm-4 text-center">...</div>
        </div>
    </div>
    
@endsection