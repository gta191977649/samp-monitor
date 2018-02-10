<template>
    <div>
        <h3 class="text-center" v-show="!data.length">暂无玩家</h3>
        <div>
            {{this.data}}
            <table class="table">
            <tbody>
            
                <tr>
                    <td>服务器名:</td>
                    <td>{{this.data.hostname}}</td>
                </tr>
                <tr>
                    <td>地址:</td>
                    <td>
                        {{this.ip}}:{{this.port}}
                    </td>
                </tr>
                <tr>
                    <td>网站:</td>
                    <td>{{this.data.weburl}}</td>
                </tr>
                <tr>
                    <td>地图版本:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>SAMP版本:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>状态:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>实时 Ping: <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="实时获得到的延迟 (基于本机房)"></i></td>
                    <td>{{this.ping}}</td>
                </tr>
                <tr>
                    <td>Ping 平均:  <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="此服务器本周的平均延迟 (基于本机房)"></i></td>
                    <td></td>
        
                </tr>
                <tr>
                    <td>玩家:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>平均玩家:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>历史最大玩家记录:</td>
                    <td>
                       
                    </td>
                </tr>
                <tr>
                    <td>游戏模式:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>评价:</td>
                    <td></td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },
        created() {
            
            //获得玩家列表查询
            axios.get('/api/samp/info/'+this.ip+'/port/'+this.port+"/",{
                    headers: {  common: {
                        'Accept': 'application/json, text/plain, */*'
                    },
                }
            })
            
            .then(response => {
                Object.assign(this.data, response.data)               
            })
            .catch(e => {
                alert(e)
            })
            //Rules
            axios.get('/api/samp/rules/'+this.ip+'/port/'+this.port+"/",{
                    headers: {  common: {
                        'Accept': 'application/json, text/plain, */*'
                    },
                }
            })
            .then(response => {
                //this.data.push(response.data)  
                Object.assign(this.data, response.data)            
            })
            .catch(e => {
                alert(e)
            }),
            //
            axios.get('/api/samp/ping/'+this.ip+'/port/'+this.port+"/",{
                    headers: {  common: {
                        'Accept': 'application/json, text/plain, */*'
                    },
                }
            })
            .then(response => {
                this.ping = response.data ?  response.data : "取得失败"         
            })
            .catch(e => {
                alert(e)
            })

        
        },
        props: ['divClass','ip','port'],
        data: function () {
            return {
                data: [],
                ping: "加载中...",
            }
        }
        
    }
</script>
