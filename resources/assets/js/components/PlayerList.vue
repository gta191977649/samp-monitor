<template>
    <div>
        <h3 class="text-center" v-show="!data.length">暂无玩家</h3>
        <h3 class="text-center" v-show="data == null">取得失败</h3>

        <table class="table" v-show="data.length">
            
            <tbody>
                
                <tr>
                    <th>ID</th>
                    <th>昵称</th>
                    <th>分数</th>
                    <th>延迟</th>
                </tr>
                <tr v-for="d in data">
                    <td>{{d.playerid}}</td>
                    <td>{{d.nickname}}</td>
                    <td>{{d.score}}</td>
                    <td>{{d.ping}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            
        },
        created() {
            
            //获得玩家列表查询
            axios.get('/api/samp/playerlist/'+this.ip+'/port/'+this.port,{
                    headers: {  common: {
                        'Accept': 'application/json, text/plain, */*'
                    },
                }
            })
            
            .then(response => {
                this.data = response.data               
            })
            .catch(e => {
                alert(e)
            })
        },
        props: ['divClass','ip','port'],
        data: function () {
            return {
                data: []
            }
        }
        
    }
</script>
