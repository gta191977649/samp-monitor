<template>
    <p v-if="livePing">{{livePing}}ms</p>
    <p v-else>取得失败</p>
</template>
<script>
    export default {
        props: ['ip','port'],
        data(){
            return{
                livePing : null
            }
        },
        mounted() {
            axios.get('/api/samp/ping/'+this.ip+'/port/'+this.port)
            .then((response) => {
                this.livePing = response.data
            })  
        },
    }
</script>
