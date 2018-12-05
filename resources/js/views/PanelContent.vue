<template>
    <div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header" >
                            <button class="btn btn-link" type="button"  v-on:click="verForm = !verForm">
                                <strong>Filter</strong> Campaigne Mistery Alicorp
                            </button>
                        </div>
                        <div class="card-body" v-if="verForm" id="collapseOne" data-parent="#accordion">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Campaña</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-sm" v-model="selectedCompany" @change="loadCombos">
                                        <option value="" disabled>Seleccionar</option>
                                        <option v-for="company in companies"  :value='company'>{{ company.fullname }} </option>
                                    </select>
                                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                </div>
                                <label class="col-md-2 col-form-label">Auditorias</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-sm" v-model="selectedAudit" @change="populateCategory">
                                        <option value="" disabled>Seleccionar</option>
                                        <option v-for="audit in audits"  :value="audit">{{ audit.nameAudit }} </option>
                                    </select>
                                    <loading :active.sync="isLoading1" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Oficinas</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-sm" v-model="selectedUbigeo" @change="loadGraph()">
                                        <option value="" disabled>Seleccionar</option>
                                        <option v-for="ubigeo in ubigeos"  :value="ubigeo.ubigeo">{{ ubigeo.ubigeo }} </option>
                                    </select>
                                    <loading :active.sync="isLoading2" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                </div>
                                <label class="col-md-2 col-form-label">Preguntas</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-sm" v-model="selectedCategory" @change="loadFirst()">
                                        <option value="" disabled>Seleccionar</option>
                                        <option v-for="category in categories"  :value="category" >{{ category.fullname }} </option>
                                    </select>
                                    <loading :active.sync="isLoading3" :can-cancel="false" :is-full-page="false" :height="20"></loading>
                                </div>
                            </div>
                            <b-alert :show="dismissCountDown"
                                     dismissible
                                     fade
                                     variant="info"
                                     @dismissed="dismissCountDown=0"
                                     @dismiss-count-down="countDownChanged">
                                {{mensaje}}
                            </b-alert>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center mt-3">
                                <div class="col-lg-4 col-sm-4 col-md-4 mb-2 mb-xl-0 text-center">
                                    <button class="btn btn-primary" type="link"><i class="icon-home"></i> Base:
                                        <span class="badge badge-light badge-pill" style="position: static;">{{base}}</span>
                                    </button>
                                    <button class="btn btn-primary" type="link"><i class="icon-pie-chart"></i> Ruteados:
                                        <span class="badge badge-light badge-pill" style="position: static;">{{ruteados}}</span>
                                    </button>
                                    <button class="btn btn-primary" type="link"><i class="icon-pie-chart"></i> Efectivos:
                                        <span class="badge badge-light badge-pill" style="position: static;">{{efectivos}}</span>
                                    </button>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-md-8 mb-2 mb-xl-0 text-center">
                                    <span class="badge badge-pill badge-success" v-if="selectedCompany != ''">{{selectedCompany.fullname}}</span>
                                    <span class="badge badge-success" v-if="selectedAudit != ''">{{selectedAudit.audit}}</span>
                                    <span class="badge badge-success" v-if="selectedUbigeo != ''">{{selectedUbigeo}}</span>
                                    <span class="badge badge-pill badge-success" v-if="selectedCategory != ''">{{selectedCategory.fullname}}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
<!--<div class="row">
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
</div>-->

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" v-for="poll in polls"  v-bind:key="poll.id">
                    <div class="card">
                        <div class="card-header">
                            {{poll.question + "(" + poll.id + " tipo: " + poll.sino + " " + poll.options + ")"}}
                        </div>
                        <div class="card-body pb-0">
                            <BlockGraph :poll="poll" :ubigeo="selectedUbigeo"></BlockGraph>
                        </div>
                    </div>
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
    import { Callout } from '../components/'

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    import BlockGraph from "./components/BlockGraph";




    export default {
        name: 'PanelContent',
        components: {
            BlockGraph,
            Callout,

            Loading
        },
        mounted() {
            this.sidebarToggle();
            this.getCampaignes();
            /*let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);*/


            EventBus.$on('changeCategories', (item) => {
                //console.log(item)
                this.audit_id=item;
                this.populateCategory()
            });
        },
        props: [],
        data(){
            return{
                verForm:true,
                mensaje:'',
                base:0,
                ruteados:0,
                efectivos:0,
                switch:false,
                dismissSecs: 2,
                dismissCountDown: 0,
                company_id:203,
                audit_id:585,
                customer_id:4,
                study_id:17,
                selectedCompany:'',
                selectedAudit:'',
                selectedUbigeo:'',
                selectedCategory:'',
                companies: [],
                audits: [],
                ubigeos: [],
                categories: [],
                polls:[],
                storebase: 0,
                datacollection: null,
                dataPollBar: null,

                isLoading: false,
                isLoading1: false,
                isLoading2: false,
                isLoading3: false,
                fullPage: false
            }
        },
        methods:{
            sidebarToggle (e) {
                document.body.classList.toggle('sidebar-minimized');
            },
            countDownChanged (dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            showAlert () {
                this.dismissCountDown = this.dismissSecs;
            },
            loadCombos (){
                this.polls = [];
                this.categories = [];
                this.ubigeos = [];
                this.selectedUbigeo='';
                this.selectedAudit='';
                this.selectedCategory='';
                this.getUbigeos();
                this.getAudits();
                this.base = 0;
                this.ruteados = 0;
                this.efectivos = 0;
                //this.getBaseEfectivos();
            },
            getAudits(){
                this.isLoading1 = true;
                let urlCombo = '/api/getAudits/' + this.selectedCompany.id ;
                axios.get(urlCombo)
                    .then((response) => {
                        this.audits = response.data;
                        this.isLoading1 = false;
                    })
                    .catch((response) => {
                        this.isLoading1 = false;
                        console.log('Error', error);
                    })
            },
            getUbigeos()
            {
                this.ubigeos = [];
                this.isLoading2 = true;
                let urlCombo = '/api/getUbigeosForCampaigne/'+ this.selectedCompany.id;
                axios.get(urlCombo)
                    .then((response) => {
                        this.ubigeos = response.data
                        this.isLoading2 = false;
                        //this.getCategories();
                    })
                    .catch((response) => {
                        this.isLoading2 = false;
                        console.log('Error', error);
                    })
            },
            getCampaignes()
            {
                this.companies = [];
                this.isLoading = true;
                let urlCombo = '/api/getCampaignes/'+ this.customer_id + '/1/' + this.study_id + '/T/';
                axios.get(urlCombo)
                    .then((response) => {
                        //console.log(response.data)
                        this.companies = response.data;
                        this.isLoading = false;
                    })
                    .catch((response) => {
                        this.isLoading = false;
                        console.log('Error', error);
                    })
            },
            populateCategory(){
                this.polls = [];
                this.categories = [];
                this.isLoading3 = true;
                this.getBaseEfectivos();
                let urlCombo = '/api/getCategoryPoll/'+ this.selectedCompany.id + '/' + this.selectedAudit.id;
                axios.get(urlCombo)
                    .then((response) => {
                        // console.log(response)
                        this.categories = response.data
                        this.isLoading3 = false;
                    })
                    .catch((response) => {
                        this.isLoading3 = false;
                        console.log('Error', error);


                    })
            },
            loadFirst:function()
            {
                this.switch = true;
                this.loadGraph();
            },
            loadGraph:function() {

                this.getBaseEfectivos();
                if (this.switch)
                {
                    this.fillData()
                }
                // console.log(this.selectedCategory.id)
            },

            getBaseEfectivos:function()
            {
                let urlBase = '/api/getBaseForCompanyAudit';
                let ubigeoVal="0";
                if (this.selectedUbigeo != '')
                {
                    ubigeoVal=this.selectedUbigeo;
                }
                if (this.selectedAudit != '')
                {
                    axios.post(urlBase, {
                        company_id: this.selectedCompany.id,
                        ubigeo: ubigeoVal,
                        audit_id: this.selectedAudit.audit_id
                    })
                        .then((response) => {
                            this.base = response.data[0].base;
                            this.ruteados = response.data[0].router;
                            this.efectivos = response.data[0].efectivos;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }

            },
            fillData () {
                if (this.selectedUbigeo != '')
                {
                    this.mensaje = "Categoria: " + this.selectedCategory.fullname + "(" + this.selectedCategory.category_id + ") Ubigeo: " + this.selectedUbigeo;
                }else{
                    this.mensaje = "Categoria: " + this.selectedCategory.fullname + "(" + this.selectedCategory.category_id + ")";
                }

                this.showAlert();

                let  category_id = this.selectedCategory.category_id;
                //console.log(this.selectedUbigeo + '-' +this.selectedCategory.category_id);
                this.polls = [];
                let urlPolls = '/api/getPollsForCategory/' + category_id + '/' + this.selectedAudit.id;
                axios.get(urlPolls)
                    .then((response) => {
                        this.mensaje = "Loaded questions";
                        this.polls = response.data;
                        this.verForm=false;
                    })
                    .catch((response) => {
                        console.log('Error', error);
                    })

            },

        }
    }
</script>
