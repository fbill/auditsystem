<template>
    <div class="chart-wrapper" >
        <loading :active.sync="isLoading2" :can-cancel="false" :is-full-page="false" :height="20"></loading>
        <div v-if="poll.sino==1">
            <CardDoughnutStoreBase :value="poll.id"  :chart-data="datacollection" class="chart-wrapper px-3" style="height:200px;" />
        </div>
        <div v-if="poll.options==1">
            <BarChartPolls   :chart-data="dataPollBar" class="chart-wrapper px-3" style="height:200px;"   />
        </div>
    </div>

</template>

<script>
    import CardDoughnutStoreBase from '../dashboard/DoughnutStoreBase';
    import BarChartPolls from '../dashboard/BarChartPolls'
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "BlockGraph",
        props:['poll'],
        components: {
            CardDoughnutStoreBase,
            BarChartPolls,
            Loading
        },
        mounted() {
            this.getResponses();
        },
        data(){
            return{
                datacollection: null,
                dataPollBar: null,
                isLoading2: false,
                fullPage: false
            }
        },
        methods:{
            getResponses(){
                this.isLoading2 = true;
                let type;
                if (this.poll.sino==1){
                    type=1;
                }
                if (this.poll.options==1){
                    type=2;
                }
                if ((this.poll.sino==1) && (this.poll.options==1))
                {
                    type=3;
                }
                let poll_id = this.poll.id;
                let urlResponse = '/api/getPollDetailsForPollId/' + poll_id +'/' + type;
                axios.get(urlResponse)
                    .then((response) => {
                        this.isLoading2 = false;
                        console.log(type)
                        if ((type==1) || (type==3)){
                            let si = response.data['si'];
                            let no = response.data['no'];
                            this.datacollection = {
                                labels: ['Si', 'No'],
                                datasets: [
                                    {
                                        backgroundColor: [
                                            '#36A2EB',
                                            '#FF6384',
                                            '#00D8FF',
                                            '#DD1B16'
                                        ],
                                        data: [si, no ]
                                    }
                                ]
                            }
                        }
                        if ((type==2) || (type==3)){
                            this.dataPollBar = {
                                labels:response.data['opciones'],
                                type: 'horizontalBar',
                                datasets:[
                                    {
                                        label:'Opciones',
                                        backgroundColor:'#36A2EB',
                                        data:response.data['count']
                                    }
                                ]
                            }
                        }


                    })
                    .catch((response) => {
                        this.isLoading2 = false;
                        console.log('Error', error);


                    })
            }
        }
    }
</script>

<style scoped>

</style>