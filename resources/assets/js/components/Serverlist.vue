<template>
    <div>
       
        <!--
        Info:
         

        {{dymicInfo}}-->
        
        <h1 v-show="servers.length == 0" class="text-center">Loading..</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>服务器</th>
                    <th>地址</th>
                    <th>模式</th>
                    <th>玩家</th>
                    <th>记录时间</th>
                </tr>
            </thead>
            <tbody>
            
                <tr v-for="(server,i) in servers">
                    
                    <td><a v-bind:href="'/server/detail/'+server.id"><img src="/css/samp.gif"> {{ server.hostname }}</img></a></td>
                    <td>{{server.ip}}:{{server.port}}</td>
                    <td>{{server.gamemode}}</td>
                    <td>{{server.players}}</td>
                    <td>
                        <span class="label label-default">{{server.lastrec}}</span>
                        <div v-if="server.timeout">
                            <span class="label label-success"><i class="fa fa-check"></i></span>
                        </div>
                        <div v-else>
                             <span class="label label-danger"><i class="fa fa-times"></i></span>
                        </div>
                    </td>

                  
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
   
    export default {
        mounted() {
            
            console.log('Server List mounted.')
            console.log('这次破例支援了ie9和chrome41等旧版浏览器.')
        },
        created() {
            //alert(this.divClass)
            axios.get('/api/samp/index')
            .then(response => {
                this.servers = response.data
                /*
                for (let server of this.servers) {
                    axios.get('/api/samp/info/'+server.id ).then(({data}) => {
                       
                       Object.assign(server, data)
                    })
                }
                */
               
            })
            .catch(e => {
                alert(e)
            })
        },
        props: ['divClass'],
        data: function () {
            return {
                servers: []
            
            }
        },
        methods:{

            getServerLiveInfo: function($ip,$port){
                axios.get('/api/samp/live/info/'+$ip+'/port/'+$port)
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
            },
            getServerInfo: function($id){
                axios.get('/api/samp/info/'+$id)
                    .then(response => {
                        this.dymicInfo.push({
                        hostname: response.data.hostname,
                        players: response.data.players,
                        gamemode: response.data.gamemode
                    })
                        
                })
                .catch(e => {
                     
                })
            }

        }
        
    }
</script>
