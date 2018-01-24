<script>
    import { Line } from 'vue-chartjs'
    import moment from 'moment'
    export default {
        extends: Line,
        props: ['id','date'],
        mounted: function () {
           //this.renderPlayerChart(1,'2017-11-15')
           //this.renderPlayerChart(this.$id,this.$date)
           //alert(this.id)
            this.playersChart(this.id,this.date)
            /*
            this.renderPlayerChart(1,this.dates[0])
            */
            
        },
        watch: {
            date: function(val){
                this.playersChart(this.id,val)
            }
        },
        data: function () {
            return {
                labels: [],
                players: [],
                dates: []
            }
        },
        methods:{
            playersChart: function($serverId,$index){
                    /*http://127.0.0.1:8000/server/playerrecdate/1*/ 
                
                axios.get(`http://127.0.0.1:8000/server/playerrecdate/`+$serverId)
                .then(response => {
                    //alert(`http://127.0.0.1:8000/server/playerrecdate/1`)
                    for (let date of response.data) {
                        this.dates.push(date.date)
                    }

                    this.renderPlayerChart($serverId,this.dates[$index])
                })
                .catch(e => {
                    alert(e)
                })
            },
            renderPlayerChart: function($serverId,$date){
                axios.get(`http://127.0.0.1:8000/server/playerrecord/`+$serverId+`/`+$date)
                .then(response => {
                    let records = response.data
                    for (let record of records) {
                        this.labels.push(moment(record.created_at).format("h:mm:ss"))
                        this.players.push(record.player)
                    }
                    
                    this.renderChart({
                        labels: this.labels,
                        datasets: [
                        {
                            label: '玩家',
                            backgroundColor: '#f87979',
                            data: this.players,
                            backgroundColor: [
                            'rgba(41, 128, 185,0)',
                            ],
                            borderColor: [
                                'rgba(41, 128, 185,255)',
                            ],
                            borderWidth: 1
                        }],
                
                }, {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    },beginAtZero: true, maintainAspectRatio: false} )
                })
                .catch(e => {
                    alert(e)
                })
            }
        }

    }

</script>