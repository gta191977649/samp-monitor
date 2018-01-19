<template>
    <div>
        {{servers}}
         <table class="table">
            <tr>
                <th>服务器</th>
                <th>地址</th>
                <th>模式</th>
                <th>玩家</th>
                <th>状态</th>
            </tr>
            <tr v-for="server in servers">
                
                <td>{{server.name}}</td>
                <td>{{server.ip}}:{{server.port}}</td>
                <td>{{server.gamemode}}</td>
                <td>{{ getServerInfo(server.ip,server.port) }}</td>
                <td>aaa</td>
                
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

            })
            .catch(e => {
                alert(e)
            })
        },
        data: function () {
            return {
                servers: [],
                infos: []
            
            }
        },
        methods:{
            getServerInfo: function($ip,$port){
                axios.get(`/api/samp/info/`+$ip+`/port/`+$port)
                .then(response => {
                    return response.data.players
                    
                })
                .catch(e => {
                    alert(e)
                })
            }

        }
        
    }
</script>
