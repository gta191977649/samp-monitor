<template>
    <div>
       
        <!--
        Info:
         {{servers}}

        {{dymicInfo}}-->
        
        <h1 v-show="servers.length == 0" class="text-center">Loading..</h1>
         <table class="table">
            <tr>
                <th>服务器</th>
                <th>地址</th>
                <th>模式</th>
                <th>玩家</th>
                <th>状态</th>
            </tr>
            <tr v-for="server in servers">
                
                <td><a v-bind:href="'/server/detail/'+(i+1)"><img src="/css/samp.gif"> {{ server.hostname }}</img></a></td>
                <td>{{server.ip}}:{{server.port}}</td>
                <td>{{server.gamemode}}</td>
                <td>{{server.players}} / {{server.maxplayers}}</td>
                <td>{{server ? "在线" : "不在线"}}</td>
                
            </tr>
          
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Server List mounted.')
        },
        created() {
            axios.get(`/api/samp/index/`)
            .then(response => {
                this.servers = response.data
                for (let server of this.servers) {
                    axios.get(`/api/samp/info/${server.ip}/port/${server.port}`).then(({data}) => {
                        Object.assign(server, data)
                    })
                }
               
            })
            .catch(e => {
                alert(e)
            })
        },
        data: function () {
            return {
                servers: []
            
            }
        },
        methods:{
            getServerInfo: function($ip,$port){
                axios.get(`/api/samp/info/`+$ip+`/port/`+$port)
                    .then(response => {
                        this.dymicInfo.push({
                        hostname: response.data.hostname,
                        players: response.data.players,
                        maxplayers: response.data.maxplayers,
                        gamemode: response.data.gamemode
                    })
                        
                })
                .catch(e => {
                     
                })
            }

        }
        
    }
</script>
