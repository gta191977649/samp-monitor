<template>
    <div>
        <div class="form-inline">
            <label for="sel1">历史记录:</label>
            <select class="form-control" v-model="selectedDate">
                <option value="">最新</option>
                <option v-for="(date,i) in dates" v-bind:value="i">{{date}}</option>
            </select>
           
        </div>
        <player-chart :height="200" :chart-data="datacollection" :options="options"></player-chart>
    </div>
</template>

<script>
    import moment from 'moment'
    Vue.component('player-chart', require('./PlayerChart.vue'));
    export default {
        props: ['id'],
        mounted() {
            //获取Date
            axios.get(`api/server/playerrecdate/`+this.id)
                .then(response => {
                    //alert(`http://127.0.0.1:8000/server/playerrecdate/1`)
                    for (let date of response.data) {
                        this.dates.push(date.date)
                    }
                })
                .catch(e => {
                    alert(e)
            }),

           this.renderPlayerChart(this.id,"NAN")
        },
        watch: {
            selectedDate: function (val) {
                this.renderPlayerChart(this.id, val == "" ? "NAN" :this.dates[val])
            }
        },
        data: function () {
            return {
                selectedDate: '',
                options: [],
                dates: [],
                datacollection: null,
                labels: [],
                players: []
            }
        },
        methods: {
            renderPlayerChart: function($serverId,$date){
                //alert($date)
                axios.get(`api/server/playerrecord/`+$serverId+`/`+$date)
                .then(response => {
                    this.labels = []
                    this.players = []
                    let records = response.data
                    for (let record of records) {
                        this.labels.push(moment(record.created_at).format("H"))
                        this.players.push(record.player)
                    }
                    this.fillData()
                })
                .catch(e => {
                    alert(e)
                })
                
            },
            fillData () {
                this.datacollection = {
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
                        
                        }
                    ]
                },
                this.options = {
                   scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    },beginAtZero: true, maintainAspectRatio: false
                }
            },
            getRandomInt () {
                return Math.floor(Math.random() * (50 - 5 + 1)) + 5
            }
        }
    
    }
</script>
