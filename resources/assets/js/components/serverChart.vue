<template>
    <div>
      
    </div>
</template>

<script>
    export default {
        mounted() {
            this.renderChart({
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                label: 'Data One',
                backgroundColor: '#f87979',
                data: [40, 39, 10, 40, 39, 80, 40]
                }
            ]
            }, {responsive: true, maintainAspectRatio: false})
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
