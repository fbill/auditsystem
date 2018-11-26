<template>
    <div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <b-card class=" " :no-block="true">
                        <h3>Campaña</h3>
                        <select v-model="selectedCompany"  class="form-control" @change="loadGraph" >
                            <option v-for="company in companies"  :value="company.id" v-bind:value="company">{{ company.fullname }} </option>
                        </select>
                        <span>Selected: {{ selectedCompany.fullname }}</span>

                    </b-card>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-4 ">
                    <b-card class=" " :no-block="true">
                        <div class="card-body pb-0">
                            <h4 class="mb-0">{{storebase}}</h4>
                            <p>Tiendas Base</p>
                        </div>
                        <CardDoughnutStoreBase :chart-data="datacollection" class="chart-wrapper px-3" style="height:200px;" />
                    </b-card>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <b-card class=" " :no-block="true">
                        <div class="card-body pb-0">
                            <h4 class="mb-0">{{storebase}}</h4>
                            <p>Tiendas Base</p>
                        </div>
                        <CardDoughnutStoreBase :chart-data="datacollection" class="chart-wrapper px-3" style="height:200px;" />
                    </b-card>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <b-card class=" " :no-block="true">
                        <div class="card-body pb-0">
                            <h4 class="mb-0">{{storebase}}</h4>
                            <p>Tiendas Base</p>
                        </div>
                        <CardDoughnutStoreBase :chart-data="datacollection" class="chart-wrapper px-3" style="height:200px;" />
                    </b-card>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-lg-12 ">
                    <b-card class=" " :no-block="true">
                        <div class="card-body pb-0">
                            <h4 class="mb-0">{{storebase}}</h4>
                            <p>Tiendas Base</p>
                        </div>
                        <BarChartPolls   :chart-data="dataPollBar" class="chart-wrapper px-3" style="height:200px;"   />
                    </b-card>
                </div>
            </div>

        </div>

        <!--Loading Complemento-->
        <div class="vld-parent">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="fullPage">
            </loading>

        </div>
    </div>

</template>

<script>
    import CardDoughnutStoreBase from './dashboard/DoughnutStoreBase'
    import BarChartPolls from './dashboard/BarChartPolls'
    import { Callout } from '../components/'

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';


    export default {
        name: 'DashboardContent',
        components: {
            Callout,
            CardDoughnutStoreBase,
            BarChartPolls,

            Loading
        },
        mounted() {
            this.populateCompanies()

        },
        props: [],
        data(){
            return{
                selectedCompany: '',
                companies: [],
                storebase: 0,
                datacollection: null,
                dataPollBar: null,

                isLoading: false,
                fullPage: true
            }
        },
        methods:{
            populateCompanies(){
                this.isLoading = true
                axios.get('/api/companies')
                    .then((response) => {
                        console.log(response)
                        this.companies = response.data
                        this.isLoading = false;
                    })
                    .catch((response) => {
                        this.isLoading = false;
                        console.log('Error', error);


                    })
            },
            loadGraph:function() {
                this.fillData(this.selectedCompany.id)
                console.log(this.selectedCompany.id)
            },

            fillData () {
                let  company_id = this.selectedCompany.id
                //console.log(this.selectedCompany.id)
                let url = '/api/getGraphStores/' + company_id ;
                this.isLoading = true;

                axios.all([axios.get(url), axios.get(url)])
                    .then(axios.spread((response,responsePoll) => {
                        console.log( response.data[0].base)
                        console.log(response.data.map(list => response.data[0]))
                        let base = response.data[0].base
                        let ruteados = response.data[0].router
                        let porRutear = base - response.data[0].router

                        this.datacollection = {
                            labels: ['Rueados', 'Por rutear'],
                            datasets: [
                                {
                                    backgroundColor: [
                                        '#36A2EB',
                                        '#FF6384',
                                        '#00D8FF',
                                        '#DD1B16'
                                    ],
                                    data: [ruteados, porRutear ]
                                }
                            ]
                        }
                        this.storebase = base

                        this.dataPollBar = {
                            labels:['Abiertos', 'Cerrados'],
                            datasets:[
                                {
                                    label:'GitHub Commits',
                                    backgroundColor:'#f87979',
                                    data:[responsePoll.data[0].base, responsePoll.data[0].router]
                                }
                            ]
                        }

                        this.isLoading = false;
                    }))
                    .catch(function (error) {
                       console.log(error);
                        this.isLoading = false;
                    })

            },

        }
    }
</script>
