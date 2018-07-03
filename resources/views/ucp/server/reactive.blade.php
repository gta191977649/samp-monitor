@extends('layouts.app')

@section('content')
    
    <div class="row" >
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>从新激活: {{$server->hostname}}</h1>
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
        <form action="{{ route('ucp.server.active',['id'=>$server->id]) }}" method = "post" id="active-forms">
            {{ csrf_field() }}

            <div class="form-group">
                <label>地址:</label>
                <input v-model.lazy="serverAddr" name= "ip" type="text" class="form-control" id="ip" required>
            </div>
            <div class="form-group">
                <label>端口:</label>
                <input v-model.lazy="serverPort" name= "port" type="number" class="form-control" id="port" required>
            </div>
        <p v-cloak v-if="serverHostName" class="text-success">服务器信息取得成功<br/>@{{serverHostName}}</p>
            <p v-cloak v-if="!serverHostName && serverAddr && serverPort" class="text-danger">服务器信息取得失败,请在确人信息</p>
            <button v-cloak v-if="serverHostName" type="submit" class="btn btn-primary">激活数据收集</button>
            <button v-cloak v-else type="submit" class="btn btn-primary" disabled>激活数据收集</button>
        </form>

        </div>
    </div>
    
@endsection

@section('js')
    <script>
        new Vue({
            el: "#active-forms",
            data () {
                return {
                    serverAddr: "{{$server->ip}}",
                    serverPort: "{{$server->port}}",
                    serverHostName: ""
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
            mounted() {
                this.requestInfo()
            },
            methods: {
                requestInfo: function() {
                    
                    axios.get('/api/samp/live/info/'+this.serverAddr+'/port/'+this.serverPort)
                    .then((response) => {
                        if(response.status != 404) {
                            this.serverHostName = response.data.hostname
                        }
                    })
                    .catch((error) => {
                        console.log("Sever info request fail")
                
                    }) 
                    
                }
            }
        });
    </script>

@endsection
