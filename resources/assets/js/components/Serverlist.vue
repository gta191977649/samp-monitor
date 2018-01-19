<template>
    <div>
        <!--{{servers}}
        Info:
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
            <tr v-for="(server,i) in servers">
                
                <td><a v-bind:href="'/server/detail/'+(i+1)"><img src="css/samp.gif"> {{ dymicInfo[i].hostname ? dymicInfo[i].hostname : server.name }}</img></a></td>
                <td>{{server.ip}}:{{server.port}}</td>
                <td>{{dymicInfo[i].gamemode ?  dymicInfo[i].gamemode : server.gamemode}}</td>
                <td>{{dymicInfo[i].maxplayers ? dymicInfo[i].players +"/"+dymicInfo[i].maxplayers : "不在线"}}</td>
                <td>{{dymicInfo[i].hostname ? "在线" : "不在线"}}</td>
                
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
                this.servers.forEach((server) => {
                    this.getServerInfo(server.ip,server.port)
                });
            })
            .catch(e => {
                alert(e)
            })
        },
        data: function () {
            return {
                servers: [],
                dymicInfo: []
            
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
                        gamemode: response.data.gamemode,
                })
                    
                })
                .catch(e => {
                    
                })
            }

        }
        
    }
</script>
