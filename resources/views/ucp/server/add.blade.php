@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>添加服务器</h1>
        <hr/>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('ucp.server.store') }}" method = "post" id="server-forms">
            {{ csrf_field() }}

            <div class="form-group">
                <label>地址:</label>
                <input v-model.lazy="serverAddr" name= "ip" type="text" class="form-control" id="ip" placeholder="服务器地址" required>
            </div>
            <div class="form-group">
                <label>端口:</label>
                <input v-model.lazy="serverPort" name= "port" type="number" class="form-control" id="port" placeholder="端口(一般:7777)" required>
            </div>
            <div class="form-group">
                <label>名称(当离线时使用):</label>
                <p v-cloak v-if="serverHostName" class="text-success">服务器名称取得成功</p>
                <p v-cloak v-if="!serverHostName && serverAddr && serverPort" class="text-danger">服务器名称取得失败,请手动填写</p>
                <input v-model="serverHostName" name= "hostname" type="text" class="form-control" id="text" placeholder="名称" required>
            </div>
            <div class="form-group">
                <label>模式(分类使用):</label>
                <input v-model="serverMode"  name= "gamemode" type="text" class="form-control" id="text" placeholder="名称" required>
            </div>
            <div class="form-group">
                <label>介绍(可选):</label>
                <textarea name= "description" type="text" class="form-control" id="text" placeholder="介绍...">
                </textarea>
            </div>
            
            
            <label>非公开:</label>
            <input type="checkbox" id="hide_ck">

            <input type="hidden" name="hide" id="ck_cache" value="0" required>
            <button type="submit" class="btn btn-primary">添加</button>

            
        </form>

        </div>
    </div>
    
@endsection
@section('js')
    <script>
        new Vue({
            el: "#server-forms",
            data () {
                return {
                    serverAddr: "",
                    serverPort: "",
                    serverHostName: "",
                    serverMode: ""
                }
            },
            watch: {
                serverAddr(val,old) {
                    if(this.serverAddr != null && this.serverPort != null) {
                        this.requestInfo()
                    }
                },
                serverPort(val,old) {
                    if(this.serverAddr != null && this.serverPort != null) {
                        this.requestInfo()
                    }
                },
            },
            methods: {
                requestInfo: function() {
                    
                    axios.get('/api/samp/live/info/'+this.serverAddr+'/port/'+this.serverPort)
                    .then((response) => {
                        if(response.status != 404) {
                            this.serverHostName = response.data.hostname
                            this.serverMode = response.data.gamemode
                        }
                    })
                    .catch((error) => {
                        console.log("Sever info request fail")
                
                    }) 
                    
                }
            }
        })
    </script>
@endsection