<template>
    <div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-lg-12">

                    <b-card class=" " :no-block="true">
                        <h3>Categoria de Preguntas</h3>
                        <select v-model="selectedCategory"  class="form-control" @change="loadGraph" >
                            <option v-for="category in categories"  :value="category.id" v-bind:value="category">{{ category.fullname }} </option>
                        </select>
                        <span>{{mensaje}}</span>{{audit_id}}

                    </b-card>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="false" :height="20"></loading>

                </div>
            </div>
<div class="row">
    <div class="col-sm-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 text-muted text-right mb-4">
                    <i class="icon-home"></i> Base
                </div>
                <div class="text-value mb-2 text-center"><h1 class="text-info">800</h1></div>
                <small class="text-muted text-uppercase font-weight-bold">Ruteados</small>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 text-muted text-right mb-4">
                    <i class="icon-pie-chart"></i> Total efectivos
                </div>
                <div class="text-value mb-2 text-center"><h1 class="text-info">789</h1></div>
                <small class="text-muted text-uppercase font-weight-bold">Avanzado</small>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100">63%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 text-muted text-right mb-4">
                    <i class="icon-pie-chart"></i> Total Lima
                </div>
                <div class="text-value mb-2 text-center"><h1 class="text-info">500</h1></div>
                <small class="text-muted text-uppercase font-weight-bold">Avanzado</small>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 72%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">72%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="h4 text-muted text-right mb-4">
                    <i class="icon-pie-chart"></i> Total Provincias
                </div>
                <div class="text-value mb-2 text-center"><h1 class="text-info">289</h1></div>
                <small class="text-muted text-uppercase font-weight-bold">Avanzado</small>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 83%;" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100">83%</div>
                </div>
            </div>
        </div>
    </div>
</div>

            <div class="row">
                <div class="col-sm-12 col-lg-6" v-for="poll in polls"  v-bind:key="poll.id">
                    <b-card class=" card-columns cols-2" :no-block="true">
                        <div class="card-body pb-0">
                            <h4 class="mb-0">{{poll.question + "(" + poll.id + " tipo: " + poll.sino + " " + poll.options + ")"}}</h4>
                        </div>
                        <BlockGraph :poll="poll"></BlockGraph>
                    </b-card>
                </div>
            </div>

        </div>

        <!--Loading Complemento-->
        <!--<div class="vld-parent">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="fullPage">
            </loading>

        </div>-->
    </div>

</template>

<script>
    import EventBus from '../bus'
    import CardDoughnutStoreBase from './dashboard/DoughnutStoreBase'
    import BarChartPolls from './dashboard/BarChartPolls'
    import { Callout } from '../components/'

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import BlockGraph from "./components/BlockGraph";


    export default {
        name: 'PanelContent',
        components: {
            BlockGraph,
            Callout,
            CardDoughnutStoreBase,
            BarChartPolls,

            Loading
        },
        mounted() {
            EventBus.$on('changeCategories', (item) => {
                //console.log(item)
                this.audit_id=item;
                this.populateCategory()
            });
        },
        props: [],
        data(){
            return{
                mensaje:'',
                company_id:203,
                audit_id:585,
                selectedCategory: '',
                categories: [],
                polls:[],
                storebase: 0,
                datacollection: null,
                dataPollBar: null,

                isLoading: false,
                fullPage: false
            }
        },
        methods:{
            populateCategory(){
                this.polls = [];
                this.isLoading = true;
                let urlCombo = '/api/getCategoryPoll/'+ this.company_id + '/' + this.audit_id;
                axios.get(urlCombo)
                    .then((response) => {
                        // console.log(response)
                        this.categories = response.data
                        this.isLoading = false;
                    })
                    .catch((response) => {
                        this.isLoading = false;
                        console.log('Error', error);


                    })
            },
            loadGraph:function() {
                this.fillData(this.selectedCategory.category_id)
                // console.log(this.selectedCategory.id)
            },

            fillData () {
                this.mensaje = "Selected: " + this.selectedCategory.fullname + this.selectedCategory.category_id;
                this.isLoading = true;
                let  category_id = this.selectedCategory.category_id;
                //console.log(this.selectedCategory.category_id)
                let urlPolls = '/api/getPollsForCategory/' + category_id;
                axios.get(urlPolls)
                    .then((response) => {
                        this.mensaje = "Cargados Polls"
                        this.polls = response.data
                        this.isLoading = false;
                    })
                    .catch((response) => {
                        this.isLoading = false;
                        console.log('Error', error);
                    })

            },

        }
    }
</script>
