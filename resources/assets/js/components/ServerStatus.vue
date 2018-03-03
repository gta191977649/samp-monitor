<template>
    <div>
        
        <div>
           
            <table class="table">
            <tbody>
            
                <tr>
                    <td>服务器名:</td>
                    <td>{{this.data.hostname ? this.data.hostname : "取得失败"}}</td>
                </tr>
                <tr>
                    <td>地址:</td>
                    <td>
                        {{this.ip}}:{{this.port}}
                    </td>
                </tr>
                <tr>
                    <td>网站:</td>
                    <td>{{this.data.weburl ? this.data.weburl : "取得失败"}}</td>
                </tr>
                <tr>
                    <td>游戏模式:</td>
                    <td>{{this.data.gamemode ? this.data.gamemode : "取得失败"}}</td>
                </tr>
                <tr>
                    <td>地图版本:</td>
                    <td>{{this.data.mapname ? this.data.mapname : "取得失败"}}</td>
                </tr>
                <tr>
                    <td>SAMP版本:</td>
                    <td>{{this.data.version? this.data.version : "取得失败"}}</td>
                </tr>
               
                <tr>
                    <td>实时 Ping: <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="实时获得到的延迟 (基于本机房)"></i></td>
                    <td>{{this.ping == null ? "超时" : this.ping + "ms"}}</td>
                </tr>
                <tr>
                    <td>Ping 平均:  <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="此服务器本周的平均延迟 (基于本机房)"></i></td>
                    <td>{{this.data.avgping == null ? "取得失败" : this.data.avgping + "ms"}}</td>
        
                </tr>
                <tr>
                    <td>玩家:</td>
                    <td>{{this.data.players != null ? this.data.players : "取得失败"}}/{{this.data.maxplayers != null ? this.data.maxplayers : "取得失败"}}</td>
                </tr>
                <tr>
                    <td>平均玩家:</td>
                    <td>{{this.data.avgplayer == null ? "取得失败" : this.data.avgplayer}}</td>
                </tr>
                <tr>
                    <td>历史最大玩家记录:</td>
                    <td>
                       {{this.data.maxplayerrec}}
                    </td>
                </tr>
             
                <tr>
                    <td>评价:</td>
                    <td>N/A</td>
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
            
            
            //Rules
            axios.get('/api/samp/rules/'+this.ip+'/port/'+this.port+"/")
            .then(response => {
               //this.data.push(response.data)  
               //this.data = response.data
                Object.assign(this.data, response.data)  
               
            })
            .catch(e => {
                console.log(e)
            }),
             
            //基本数据库信息查询
            axios.get('/api/samp/info/'+this.id+"/")
            .then(response => {
                //this.data = response.data ?  response.data : "取得失败" 
                Object.assign(this.data, response.data)               
            })
            .catch(e => {
                console.log(e)
            })

            //获得玩家列表查询
            axios.get('/api/samp/live/info/'+this.ip+'/port/'+this.port+"/")
            .then(response => {
                Object.assign(this.data, response.data)  

            })
            .catch(e => {
                console.log(e)
            })

            //实施Ping
            axios.get('/api/samp/ping/'+this.ip+'/port/'+this.port+"/")
            .then(response => {
                this.ping = response.data ?  response.data : "取得失败"         
            })
            .catch(e => {
                console.log(e)
            })
          

        
        },
        props: ['divClass','ip','port','id'],
        data: function () {
            return {
                data: [],
                ping: "加载中...",
            }
        }
        
    }
</script>
